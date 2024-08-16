<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Models\Level_trainer;

class UserAccountController extends Controller
{
    const UserRoles = ['hrd', 'kurikulum', 'keuangan'];
    /**
     * Begin::Trainer Account
     */
    public function akunUser(Request $request): View
    {
        try {
            return $this->viewListAkunUser($this->getAkunUser($request), $this->getLevelTrainer(), static::UserRoles, $this->getTrashAccountAdmin($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.dashboard', 'error');
        }
    }

    public function buatAkunUser(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormBuatAkunUser($request);
        try {
            $this->masukanRequestInputFormBuatAkunUser(array_merge($this->requestInputFormBuatAkunUser($request), $this->requestInputPasswordUntukBuatAtauUpdate($request)));
            return $this->Response('Berhasil Membuat Data Akun User', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.dashboard', 'error');
        }
    }

    public function ubahAkunUser(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormUbahAkunUser($request);
        try {

            if ($this->checkIdUpdate($request)) {
                if ($this->checkApakahPasswordDiUpdate($request)) {
                    $data = $this->updateAkunUserDenganPassword($request);
                    $data['password'] = Hash::make($data['password']);
                    $this->masukanRequestInputFormUpdateAkunUser($data);
                }

                if (!$this->checkApakahPasswordDiUpdate($request)) {
                    $this->masukanRequestInputFormUpdateAkunUser($this->updateAkunUserTanpaPassword($request));
                }
            } else {
                return $this->Response('Id update salah', 'admin.account.user.list', 'error');
            }

            return $this->Response('Berhasil Mengubah Data Akun User', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.dashboard', 'error');
        }
    }

    public function hapusAkunUser(User $id): RedirectResponse
    {
        try {
            if ($this->checkIdDelete($id->id)) {
                $this->masukanRequestInputFormHapusAkunUser($id->id);
            } else {
                return $this->Response('Id delete salah', 'admin.account.user.list', 'error');
            }
            return $this->Response('Berhasil Menghapus Data Akun User', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.dashboard', 'error');
        }
    }

    public function restoreByID($id): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.account.user.list', 'error');
        }
    }

    public function restoreAll(): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.account.user.list', 'error');
        }
    }

    public function deleteByID($id): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.account.user.list', 'error');
        }
    }

    public function deleteAll(): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'admin.account.user.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'admin.account.user.list', 'error');
        }
    }

    private function doRestoreByID($id): void
    {
        User::onlyTrashed()->where('id', $id)->restore();
    }

    private function doRestoreAll(): void
    {
        User::onlyTrashed()->restore();
    }

    private function doDeleteByID($id): void
    {
        User::onlyTrashed()->where('id', $id)->forceDelete();
    }

    private function doDeleteAll(): void
    {
        User::onlyTrashed()->forceDelete();
    }

    private function validasiRequestInputFormBuatAkunUser($request)
    {
        return $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'roles' => 'required|string',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function validasiRequestInputFormUbahAkunUser($request)
    {
        return $request->validate([
            'name' => 'string',
            'username' => 'string|unique:users,username',
            'email' => 'string|email|unique:users,email',
            'roles' => 'string',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function updateAkunUserTanpaPassword($request): array
    {
        return $this->requestInputFormUpdateAkunUser($request);
    }

    private function updateAkunUserDenganPassword($request): array
    {
        return array_merge($this->requestInputFormUpdateAkunUser($request), $this->requestInputPasswordUntukBuatAtauUpdate($request));
    }

    private function requestInputPasswordUntukBuatAtauUpdate($request): array
    {
        return $request->only('password');
    }


    private function requestInputFormBuatAkunUser($request): array
    {
        return $request->only('name', 'username', 'email', 'roles');
    }

    private function requestInputFormUpdateAkunUser($request): array
    {
        return $request->only('id', 'name', 'username', 'email', 'roles');
    }

    private function checkApakahPasswordDiUpdate($request): bool
    {
        return $request->input('password') ? true : false;
    }

    private function masukanRequestInputFormBuatAkunUser($request): void
    {
        User::create($request);
    }

    private function masukanRequestInputFormUpdateAkunUser($request): void
    {
        User::where('id', $request['id'])->update($request);
    }

    private function masukanRequestInputFormHapusAkunUser($id): void
    {
        User::where('id', $id)->delete();
    }

    private function checkIdUpdate($request): bool
    {
        return User::where('id', $request['id'])->first() ? true : false;
    }
    private function checkIdDelete($id): bool
    {
        return User::where('id', $id)->first() ? true : false;
    }

    private function getAkunUser($request)
    {
        return User::where('roles', '!=', 'trainer')
            ->with('levelTrainer')
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            })
            ->when($request->email, function ($query) use ($request) {
                $query->where('email', 'like', "%{$request->email}%");
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at}%");
            })
            ->when($request->username, function ($query) use ($request) {
                $query->where('username', 'like', "%{$request->username}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function getLevelTrainer()
    {
        return Level_trainer::orderByDesc('id')->get();
    }

    private function getTrashAccountAdmin($request)
    {
        return User::onlyTrashed()
            ->where('roles', '!=', 'trainer')
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

    private function viewListAkunUser($user, $level, $getRolesUser, $getTrashAccountAdmin): View
    {
        return view('dashboard.admin.account_user', compact('user', 'level', 'getRolesUser', 'getTrashAccountAdmin'));
    }
    /**
     * End::Trainer Account
     */
}
