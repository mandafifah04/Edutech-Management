<?php

namespace App\Http\Controllers\Dashboard\Hrd;

use Illuminate\Http\Request;
use App\Models\Level_trainer;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class MasterSallaryTrainerController extends Controller
{
    public function sallaryTrainer(Request $request): View
    {
        try {
            return $this->tampilanListSallaryTrainer($this->querySallaryTrainer($request), $this->queryLevelTrainer(), $this->getTrashSallary($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function buatSallaryTrainer(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormBuatSallaryTrainer($request);
        try {
            $this->masukanRequestInputFormBuatSallaryTrainer($this->submitInputFormUpdateSallaryTrainer($request));
            return $this->Response('Berhasil Membuat Data Sallary Trainer', 'hrd.trainer.sallary.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function ubahSallaryTrainer(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormUbahSallaryTrainer($request);
        try {
            if ($this->checkIdUpdate($request)) {
                $this->masukanRequestInputFormUpdateSallaryTrainer($this->updateSallaryTrainer($request));
                return $this->Response('Berhasil Mengubah Data Sallary Trainer', 'hrd.trainer.sallary.list');
            } else {
                return $this->Response('Id update salah', 'hrd.trainer.sallary.list', 'error');
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function hapusSallaryTrainer(Level_trainer $id): RedirectResponse
    {
        try {
            if ($this->checkIdDelete($id->id)) {
                $this->masukanRequestInputFormHapusSallaryTrainer($id->id);
            } else {
                return $this->Response('Id delete salah', 'hrd.trainer.sallary.list', 'error');
            }
            return $this->Response('Berhasil Menghapus Data Sallary Trainer', 'hrd.trainer.sallary.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function restoreByID($id): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'hrd.trainer.sallary.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.sallary.list', 'error');
        }
    }

    public function restoreAll(): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'hrd.trainer.sallary.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.sallary.list', 'error');
        }
    }

    public function deleteByID($id): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'hrd.trainer.sallary.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.sallary.list', 'error');
        }
    }

    public function deleteAll(): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'hrd.trainer.sallary.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.sallary.list', 'error');
        }
    }

    private function getTrashSallary($request)
    {
        return Level_trainer::onlyTrashed()
            ->when($request->nama_level_trash, function ($query) use ($request) {
                $query->where('nama_level', 'like', "%{$request->nama_level_trash}%");
            })
            ->when($request->sallary_level_trash, function ($query) use ($request) {
                $query->where('sallary_level', 'like', "%{$request->sallary_level_trash}%");
            })
            ->when($request->created_at_trash, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at_trash}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function doRestoreByID($id): void
    {
        Level_trainer::onlyTrashed()->where('id', $id)->restore();
    }

    private function doRestoreAll(): void
    {
        Level_trainer::onlyTrashed()->restore();
    }

    private function doDeleteByID($id): void
    {
        Level_trainer::onlyTrashed()->where('id', $id)->forceDelete();
    }

    private function doDeleteAll(): void
    {
        Level_trainer::onlyTrashed()->forceDelete();
    }

    private function validasiRequestInputFormBuatSallaryTrainer($request)
    {
        return $request->validate(['nama_level' => 'required|string|unique:level_trainers,nama_level', 'sallary_level' => 'required|integer',], ['required' => ':attribute wajib di isi', 'string' => ':attribute harus string']);
    }

    private function validasiRequestInputFormUbahSallaryTrainer($request)
    {
        return $request->validate(['kode_level' => 'string', 'nama_level' => 'string|unique:level_trainers,nama_level', 'sallary_level' => 'integer',], ['required' => ':attribute wajib di isi', 'string' => ':attribute harus string']);
    }

    private function updateSallaryTrainer($request): array
    {
        return $this->requestInputFormUpdateSallaryTrainer($request);
    }

    private function requestInputFormBuatSallaryTrainer($request): array
    {
        return $request->only('kode_level', 'nama_level', 'sallary_level');
    }

    private function requestInputFormUpdateSallaryTrainer($request): array
    {
        return $request->only('id', 'kode_level', 'nama_level', 'sallary_level');
    }

    private function submitInputFormUpdateSallaryTrainer($request): array
    {
        $req = $this->requestInputFormBuatSallaryTrainer($request);
        $req['kode_level'] = uniqid();
        return $req;
    }

    private function masukanRequestInputFormBuatSallaryTrainer($request): void
    {
        Level_trainer::create($request);
    }

    private function masukanRequestInputFormUpdateSallaryTrainer($request): void
    {
        Level_trainer::where('id', $request['id'])->update($request);
    }

    private function masukanRequestInputFormHapusSallaryTrainer($id): void
    {
        Level_trainer::where('id', $id)->delete();
    }

    private function checkIdUpdate($request): bool
    {
        return Level_trainer::where('id', $request['id'])->first() ? true : false;
    }
    private function checkIdDelete($id): bool
    {
        return Level_trainer::where('id', $id)->first() ? true : false;
    }

    private function querySallaryTrainer($request)
    {
        return Level_trainer::orderByDesc('id')
            ->when($request->nama_level, function ($query) use ($request) {
                $query->where('nama_level', 'like', "%{$request->nama_level}%");
            })
            ->when($request->sallary_level, function ($query) use ($request) {
                $query->where('sallary_level', 'like', "%{$request->sallary_level}%");
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at}%");
            })
            ->get();
    }

    private function queryLevelTrainer()
    {
        return Level_trainer::orderByDesc('id')->select('nama_level', 'id')->get();
    }

    private function tampilanListSallaryTrainer($trainerSallary, $level_trainer, $getTrashSallary): View
    {
        return view('dashboard.hrd.sallary_trainer', compact('trainerSallary', 'level_trainer', 'getTrashSallary'));
    }
}
