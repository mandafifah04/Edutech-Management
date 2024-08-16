<?php

namespace App\Http\Controllers\Dashboard\Kurikulum;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Assigned_kelas_trainer;
use App\Models\Jadwal_kelas;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Models\User;

class AssignedClassToTrainerController extends Controller
{

    public function assignedKelas(Request $request)
    {
        try {
            return $this->tampilanListAssignedkelas($this->getAssignedKelas($request), $this->getKelas(), $this->getUserTrainer(), $this->getTrashByAssignedClass($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function buatAssignedKelas(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormBuatAssignedKelas($request);

        try {

            if (!$this->checkIsExitsJadwalOfKelas($request)) {
                return $this->getResponseIsExitsJadwalOfKelas($request);
            }

            if ($this->IsExitsAssignedKelasToTrainer($request)) {
                return $this->responseIsExitsAssignedKelasToTrainer($request);
            }

            $this->submitRequestInputFormBuatAssignedKelas($this->requestFormBuatAssignedKelas($request));
            return $this->Response('Berhasil Assigned Kelas Ke Trainer', 'kurikulum.assigned.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function hapusAssignedKelas(Assigned_kelas_trainer $id): RedirectResponse
    {
        try {

            if ($this->checkIdDeleteAssignedKelas($id->id)) {
                $this->deleteAssignedClass($id->id);
                return $this->Response('Berhasil Menghapus Assigned Kelas Ke Trainer', 'kurikulum.assigned.list');
            } else {
                return $this->Response('Id assigned kelas salah', 'kurikulum.assigned.list', 'error');
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function restoreByID($id): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'kurikulum.assigned.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.assigned.list', 'error');
        }
    }

    public function restoreAll(): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'kurikulum.assigned.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.assigned.list', 'error');
        }
    }

    public function deleteByID($id): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'kurikulum.assigned.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.assigned.list', 'error');
        }
    }

    public function deleteAll(): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'kurikulum.assigned.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.assigned.list', 'error');
        }
    }

    private function doRestoreByID($id): void
    {
        Assigned_kelas_trainer::onlyTrashed()->whereId($id)->restore();
    }

    private function doRestoreAll(): void
    {
        Assigned_kelas_trainer::onlyTrashed()->restore();
    }

    private function doDeleteByID($id): void
    {
        Assigned_kelas_trainer::onlyTrashed()->whereId($id)->forceDelete();
    }

    private function doDeleteAll(): void
    {
        Assigned_kelas_trainer::onlyTrashed()->forceDelete();
    }

    private function getTrashByAssignedClass($request)
    {
        return Assigned_kelas_trainer::onlyTrashed()
            ->with(['kelas', 'user'])
            ->whereNotNull('users_id')
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas_trash}%");
            })
            ->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name_trash}%");
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at_trash}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function validasiRequestInputFormBuatAssignedKelas($request)
    {
        return $request->validate([
            'users_id' => 'required|integer',
            'kelas_id' => 'required|string',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function checkIsExitsJadwalOfKelas($request): bool
    {
        return Jadwal_kelas::where('kelas_id', $request['kelas_id'])->first() ? true : false;
    }

    private function getResponseIsExitsJadwalOfKelas()
    {
        return $this->Response('Belum ada jadwal untuk kelasnya', 'kurikulum.assigned.list', 'error');
    }

    private function requestFormBuatAssignedKelas($request): array
    {
        return $request->only('users_id', 'kelas_id');
    }

    private function submitRequestInputFormBuatAssignedKelas($request): void
    {
        Assigned_kelas_trainer::create($request);
    }

    private function IsExitsAssignedKelasToTrainer($request)
    {
        return (Assigned_kelas_trainer::where([['users_id', '=', $request['users_id']], ['kelas_id', '=', $request['kelas_id']]])->first());
    }

    private function responseIsExitsAssignedKelasToTrainer()
    {
        return $this->Response('Kelas telah di Assigned ke trainer', 'kurikulum.assigned.list', 'error');
    }

    private function deleteAssignedClass($id): void
    {
        Assigned_kelas_trainer::where('id', $id)->delete();
    }

    private function checkIdDeleteAssignedKelas($id): bool
    {
        return Assigned_kelas_trainer::where('id', $id)->first() ? true : false;
    }

    private function getAssignedKelas($request)
    {
        return Assigned_kelas_trainer::with(['kelas', 'user'])
            ->whereNotNull('users_id')
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas}%");
            })
            ->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function getKelas()
    {
        return Kelas::orderByDesc('id')->get();
    }

    private function getUserTrainer()
    {
        return User::where('roles', 'trainer')->orderByDesc('id')->get();
    }

    private function tampilanListAssignedkelas($getAssignedKelas, $getKelas, $getUserTrainer, $getTrashByAssignedClass): View
    {
        return view('dashboard.kurikulum.kelas_assigned', compact('getAssignedKelas', 'getKelas', 'getUserTrainer', 'getTrashByAssignedClass'));
    }
}
