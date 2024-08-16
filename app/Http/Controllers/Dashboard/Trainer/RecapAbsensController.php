<?php

namespace App\Http\Controllers\Dashboard\Trainer;

use App\Exports\RecapAbsenTrainerExport;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RecapAbsensController extends Controller
{
    public function recapAbsen(Request $request)
    {
        try {
            return $this->viewRecapAbsen($this->getRecapAbsen($request), $this->getTrashByRecapAbsen($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function exportExcelByRecapAbsens(Absen $absen)
    {
        try {
            return $this->doExportExcelByRecapAbsen($absen);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function exportPdfByRecapAbsen()
    {
        try {
            return $this->doExportPdfByRecapAbsen();
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    private function doExportPdfByRecapAbsen()
    {
        $absenExportToPDF = Absen::orderByDesc('id')
            ->whereusers_id(Auth::guard('user')->user()->id)
            ->with(['jadwal', 'user'])
            ->get();

        $doAbsenExportToPDF = PDF::loadview('dashboard.trainer.recap_absen_trainer', ['absenExportToPDF' => $absenExportToPDF]);
        return $doAbsenExportToPDF->download('recap_absen.pdf');
    }

    private function doExportExcelByRecapAbsen($absen)
    {
        return Excel::download(new RecapAbsenTrainerExport($absen), 'recap_absen.xlsx');
    }

    private function viewRecapAbsen($getRecapAbsen, $getTrashByRecapAbsen): View
    {
        return view('dashboard.trainer.recap_absens', compact('getRecapAbsen', 'getTrashByRecapAbsen'));
    }

    private function getRecapAbsen($request)
    {
        return Absen::orderByDesc('id')
            ->whereusers_id(Auth::guard('user')->user()->id)
            ->with(['jadwal', 'user'])
            ->whereHas('jadwal', function ($query) use ($request) {
                $query->where('tanggal_jadwal_kelas', 'like', "%{$request->tanggal_jadwal_kelas}%");
            })
            ->whereHas('jadwal', function ($query) use ($request) {
                $query->where('hari_jadwal_kelas', 'like', "%{$request->hari_jadwal_kelas}%");
            })
            ->get();
    }

    private function getTrashByRecapAbsen($request)
    {
        return Absen::onlyTrashed()
            ->where('users_id', Auth::guard('user')->user()->id)
            ->with(['jadwal', 'user'])
            ->whereHas('jadwal', function ($query) use ($request) {
                $query->where('tanggal_jadwal_kelas', 'like', "%{$request->tanggal_jadwal_kelas_trash}%");
            })
            ->whereHas('jadwal', function ($query) use ($request) {
                $query->where('hari_jadwal_kelas', 'like', "%{$request->hari_jadwal_kelas_trash}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    public function restoreByID($id): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'trainer.recap.absen');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'trainer.recap.absen', 'error');
        }
    }

    public function restoreAll(): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'trainer.recap.absen');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'trainer.recap.absen', 'error');
        }
    }

    public function deleteByID($id): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'trainer.recap.absen');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'trainer.recap.absen', 'error');
        }
    }

    public function deleteAll(): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'trainer.recap.absen');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'trainer.recap.absen', 'error');
        }
    }

    private function doRestoreByID($id): void
    {
        Absen::onlyTrashed()->whereId($id)->restore();
    }

    private function doRestoreAll(): void
    {
        Absen::onlyTrashed()->restore();
    }

    private function doDeleteByID($id): void
    {
        Absen::onlyTrashed()->whereId($id)->forceDelete();
    }

    private function doDeleteAll(): void
    {
        Absen::onlyTrashed()->forceDelete();
    }
}
