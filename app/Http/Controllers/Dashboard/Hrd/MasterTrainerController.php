<?php

namespace App\Http\Controllers\Dashboard\Hrd;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Models\User as Trainer;
use App\Models\Level_trainer;

class MasterTrainerController extends Controller
{
    public function akunTrainer(Request $request): View
    {
        try {
            return $this->tampilanListAkunTrainer($this->queryAkunTrainer($request), $this->queryLevelTrainer(), $this->getTrashAccountTrainer($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function buatAkunTrainer(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormBuatAkunTrainer($request);
        try {
            $this->masukanRequestInputFormBuatAkunTrainer(array_merge($this->requestInputFormBuatAkunTrainer($request), $this->requestInputPasswordUntukBuatAtauUpdate($request)));
            return $this->Response('Berhasil Membuat Data Akun Trainer', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function ubahAkunTrainer(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormUbahAkunTrainer($request);
        try {
            if ($this->checkIdUpdate($request)) {
                if ($this->checkApakahPasswordDiUpdate($request)) {
                    $data = $this->updateAkunTrainerDenganPassword($request);
                    $data['password'] = Hash::make($data['password']);
                    $this->masukanRequestInputFormUpdateAkunTrainer($data);
                }

                if (!$this->checkApakahPasswordDiUpdate($request)) {
                    $this->masukanRequestInputFormUpdateAkunTrainer($this->updateAkunTrainerTanpaPassword($request));
                }
            } else {
                return $this->Response('Id update salah', 'hrd.trainer.account.list', 'error');
            }

            return $this->Response('Berhasil Mengubah Data Akun Trainer', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function hapusAkunTrainer(Trainer $id): RedirectResponse
    {
        try {
            if ($this->checkIdDelete($id->id)) {
                $this->masukanRequestInputFormHapusAkunTrainer($id->id);
            } else {
                return $this->Response('Id delete salah', 'hrd.trainer.account.list', 'error');
            }
            return $this->Response('Berhasil Menghapus Data Akun Trainer', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function restoreByID($id): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.account.list', 'error');
        }
    }

    public function restoreAll(): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.account.list', 'error');
        }
    }

    public function deleteByID($id): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.account.list', 'error');
        }
    }

    public function deleteAll(): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'hrd.trainer.account.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.account.list', 'error');
        }
    }

    private function getTrashAccountTrainer($request)
    {
        return Trainer::onlyTrashed()
            ->where('roles', 'trainer')
            ->with('levelTrainer')
            ->when($request->name_trash, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name_trash}%");
            })
            ->when($request->email_trash, function ($query) use ($request) {
                $query->where('email', 'like', "%{$request->email_trash}%");
            })
            ->when($request->created_at_trash, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at_trash}%");
            })
            ->when($request->username_trash, function ($query) use ($request) {
                $query->where('username', 'like', "%{$request->username_trash}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function doRestoreByID($id): void
    {
        Trainer::onlyTrashed()->where([['roles', '=', 'trainer'], ['id', '=', $id]])->restore();
    }

    private function doRestoreAll(): void
    {
        Trainer::onlyTrashed()->where('roles', 'trainer')->restore();
    }

    private function doDeleteByID($id): void
    {
        Trainer::onlyTrashed()->where([['roles', '=', 'trainer'], ['id', '=', $id]])->forceDelete();
    }

    private function doDeleteAll(): void
    {
        Trainer::onlyTrashed()->where('roles', 'trainer')->forceDelete();
    }

    private function validasiRequestInputFormBuatAkunTrainer($request)
    {
        return $request->validate([
            'name' => 'required|string|unique:users,name',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email|email',
            'password' => 'required|string',
            'level_trainers_id' => 'integer|required',
            'roles' => 'required|string',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function validasiRequestInputFormUbahAkunTrainer($request)
    {
        return $request->validate([
            'name' => 'string',
            'username' => 'string|unique:users,username',
            'email' => 'string|unique:users,email|email',
            'level_trainers_id' => 'integer',
            'roles' => 'string',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function updateAkunTrainerTanpaPassword($request): array
    {
        return $this->requestInputFormUpdateAkunTrainer($request);
    }

    private function updateAkunTrainerDenganPassword($request): array
    {
        return array_merge($this->requestInputFormUpdateAkunTrainer($request), $this->requestInputPasswordUntukBuatAtauUpdate($request));
    }

    private function requestInputPasswordUntukBuatAtauUpdate($request): array
    {
        return $request->only('password');
    }


    private function requestInputFormBuatAkunTrainer($request): array
    {
        return $request->only('name', 'username', 'email', 'level_trainers_id', 'roles');
    }

    private function requestInputFormUpdateAkunTrainer($request): array
    {
        return $request->only('id', 'name', 'username', 'email', 'level_trainers_id', 'roles');
    }

    private function checkApakahPasswordDiUpdate($request): bool
    {
        return $request->input('password') ? true : false;
    }

    private function masukanRequestInputFormBuatAkunTrainer($request): void
    {
        Trainer::create($request);
    }

    private function masukanRequestInputFormUpdateAkunTrainer($request): void
    {
        Trainer::where('id', $request['id'])->update($request);
    }

    private function masukanRequestInputFormHapusAkunTrainer($id): void
    {
        Trainer::where('id', $id)->delete();
    }

    private function checkIdUpdate($request): bool
    {
        return Trainer::where('id', $request['id'])->first() ? true : false;
    }
    private function checkIdDelete($id): bool
    {
        return Trainer::where('id', $id)->first() ? true : false;
    }

    private function queryAkunTrainer($request)
    {
        return Trainer::where('roles', 'trainer')
            ->with('levelTrainer')
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            })
            ->when($request->email, function ($query) use ($request) {
                $query->where('email', 'like', "%{$request->email}%");
            })
            ->when($request->level, function ($query) use ($request) {
                $query->where('level_trainers_id', 'like', "%{$request->level}%");
            })
            ->when($request->username, function ($query) use ($request) {
                $query->where('username', 'like', "%{$request->username}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function queryLevelTrainer()
    {
        return Level_trainer::orderByDesc('id')->get();
    }

    private function tampilanListAkunTrainer($trainer, $level, $getTrashAccountTrainer): View
    {
        return view('dashboard.hrd.account_trainer', compact('trainer', 'level', 'getTrashAccountTrainer'));
    }
}
