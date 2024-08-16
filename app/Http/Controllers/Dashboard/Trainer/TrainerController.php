<?php

namespace App\Http\Controllers\Dashboard\Trainer;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Assigned_kelas_trainer;
use App\Models\Jadwal_kelas;
use App\Models\Kelas;
use App\Models\Level_trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TrainerController extends Controller
{
    const status_kelas = ['private', 'regular'];

    public function kelas(Request $request): View
    {
        try {
            return $this->viewKelasByTrainer($this->getKelasByTrainer($request), $this->getLevelTrainer(), static::status_kelas);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function trainerAbsenJadwal($id_jadwal, $kelas_id, $id_trainer)
    {
        try {
            if (!$this->getTrainerAbsenJadwal($id_jadwal, $kelas_id, $id_trainer)) {
                return $this->Response('id jadwal dan id trainer tidak boleh di kosongkan', 'trainers.kelas', 'error');
            }

            if ($this->checkIfTrainerHasExistsOfAbsen($id_jadwal, $kelas_id, $id_trainer)) {
                return $this->getResponseCheckIfTrainerHasExistsOfAbsen();
            }

            if ($this->getTrainerAbsenJadwal($id_jadwal, $kelas_id, $id_trainer)) {
                if ($this->validateIDTrainerAndIDJadwal($id_jadwal, $kelas_id, $id_trainer)) {
                    $this->doAbsenTrainerByJadwalOfKelas($this->mapRequestDoTrainerByJadwalOfKelas($id_jadwal, $kelas_id, $id_trainer));
                    return $this->getResponseDoAbsenTrainerByJadwalOfKelas();
                }
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'trainers.kelas', 'error');
        }
    }

    private function checkIfTrainerHasExistsOfAbsen($id_jadwal, $kelas_id, $id_trainer): bool
    {
        $absen = Absen::where([
            ['jadwal_kelas_id', '=', $id_jadwal],
            ['kelas_id', '=', $kelas_id],
            ['users_id', '=', $id_trainer]
        ])->first();

        if ($absen) {
            return true;
        }
        return false;
    }

    private function getResponseCheckIfTrainerHasExistsOfAbsen(): RedirectResponse
    {
        return $this->Response('Sudah Absen Di Jadwal Ini', 'trainers.kelas', 'error');
    }

    private function getResponseDoAbsenTrainerByJadwalOfKelas(): RedirectResponse
    {
        return $this->Response('Berhasil Absen Di Jadwal Pada Kelas', 'trainer.recap.absen');
    }

    private function getTrainerAbsenJadwal($id_jadwal, $id_trainer, $kelas_id): bool
    {
        return !empty($id_jadwal) && !empty($id_trainer) && !empty($kelas_id);
    }

    private function validateJadwalAbsenBYID($id_jadwal)
    {
        $jadwal = Jadwal_kelas::whereId($id_jadwal)->first();

        if ($jadwal) {
            return true;
        }
        return false;
    }

    private function validateTrainerBYID($id_trainer)
    {
        $user = User::whereId($id_trainer)->first();

        if ($user) {
            return true;
        }
        return false;
    }

    private function validateKelasBYID($kelas_id)
    {
        $kelas = Kelas::whereId($kelas_id)->first();

        if ($kelas) {
            return true;
        }
        return false;
    }

    private function validateIDTrainerAndIDJadwal($id_jadwal, $kelas_id, $id_trainer)
    {
        return $this->validateJadwalAbsenBYID($id_jadwal) && $this->validateKelasBYID($kelas_id) && $this->validateTrainerBYID($id_trainer);
    }

    private function doAbsenTrainerByJadwalOfKelas($mapRequestDoTrainerByJadwalOfKelas): void
    {
        Absen::create($mapRequestDoTrainerByJadwalOfKelas);
        $this->ChangeStatusPertemuanIfScheduleHasDone($mapRequestDoTrainerByJadwalOfKelas['jadwal_kelas_id']);
    }

    private function ChangeStatusPertemuanIfScheduleHasDone($id_jadwal): void
    {
        Jadwal_kelas::whereId($id_jadwal)->first()->update(['status' => 'Y']);
    }

    private function mapRequestDoTrainerByJadwalOfKelas($id_jadwal, $kelas_id, $id_trainer): array
    {
        return array('jadwal_kelas_id' => $id_jadwal, 'kelas_id' => $kelas_id, 'users_id' => $id_trainer);
    }

    private function getLevelTrainer()
    {
        return Level_trainer::orderByDesc('id')->get();
    }

    private function getKelasByTrainer($request)
    {
        return Assigned_kelas_trainer::with(['kelas', 'user'])
            ->where('users_id', Auth::guard('user')->user()->id)
            ->whereHas('kelas.levelTrainer', function ($query) use ($request) {
                $query->where('nama_level', 'like', "%{$request->level_trainer}%");
            })
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('status_kelas', 'like', "%{$request->status_kelas}%");
            })
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function viewKelasByTrainer($getKelasByTrainer, $getLevelTrainer, $status_kelas): View
    {
        return view('dashboard.trainer.kelas_trainer', compact('getKelasByTrainer', 'getLevelTrainer', 'status_kelas'));
    }
}
