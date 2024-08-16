<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Assigned_kelas_trainer;
use App\Models\Jadwal_kelas;
use App\Models\Kelas;
use App\Models\Level_trainer;
use App\Models\Sallaryreport;
use Illuminate\Contracts\View\View;
use App\Models\User as Trainer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function dashboard(): view
    {
        return $this->tampilanDashboard(
            $this->listSemuaAkunTrainer(),
            $this->listSemuaAkunUser(),
            $this->kurikulumKelas(),
            $this->countJadwalKelas(),
            $this->countJadwalKelasHasDelete(),
            $this->countKelasOfKurikulum(),
            $this->countKelasHasDeleteOfKurikulum(),
            $this->countAssignedClassOfKurikulum(),
            $this->countAssignedClassHasDeleteOfKurikulum(),
            $this->countSallaryAndLevels(),
            $this->getTotalSallaryReports(),
            $this->getTotalVerifySallaryReports(),
            $this->getTotalUnerifySallaryReports(),
            $this->getExpandTotalSallaryReports(),
            $this->getTotalHandleKelasTrainer(),
            $this->getTotalAbsenRecapOnTrainer(),
            $this->getCountTotalGaji(),
            $this->getAccountTrainer(),
            $this->getAccountUser(),
            $this->getAccountUserHasDeleted(),
            $this->getScheduleOnClassAndTotalTime(),
            $this->countAkunTrainer(),
            $this->getSallaryReports(),
            $this->getAbsenOfTrainer(),
            $this->getRingkasanJadwal(),
            $this->getStatistikJadwalKelasPerTrainer(),
            $this->getStatistikJadwalKelasPerHari(),
            $this->getAnalisisAbsensi(),
        );
    }

    private function tampilanDashboard(
        $listAkunTrainer,
        $listAkunUser,
        $kurikulumKelas,
        $countJadwalKelas,
        $countJadwalKelasHasDelete,
        $countKelasOfKurikulum,
        $countKelasHasDeleteOfKurikulum,
        $countAssignedClassOfKurikulum,
        $countAssignedClassHasDeleteOfKurikulum,
        $countSallaryAndLevels,
        $getTotalSallaryReports,
        $getTotalVerifySallaryReports,
        $getTotalUnerifySallaryReports,
        $getExpandTotalSallaryReports,
        $getTotalHandleKelasTrainer,
        $getTotalAbsenRecapOnTrainer,
        $getCountTotalGaji,
        $getAccountTrainer,
        $getAccountUser,
        $getAccountUserHasDeleted,
        $getScheduleOnClassAndTotalTime,
        $countAkunTrainer,
        $getSallaryReports,
        $getAbsenOfTrainer,
        $getRingkasanJadwal,
        $getStatistikJadwalKelasPerTrainer,
        $getStatistikJadwalKelasPerHari,
        $getAnalisisAbsensi,
    ): View {
        return view('dashboard.index', compact(
            'listAkunTrainer',
            'listAkunUser',
            'kurikulumKelas',
            'countJadwalKelas',
            'countJadwalKelasHasDelete',
            'countKelasOfKurikulum',
            'countKelasHasDeleteOfKurikulum',
            'countAssignedClassOfKurikulum',
            'countAssignedClassHasDeleteOfKurikulum',
            'countSallaryAndLevels',
            'getTotalSallaryReports',
            'getTotalVerifySallaryReports',
            'getTotalUnerifySallaryReports',
            'getExpandTotalSallaryReports',
            'getTotalHandleKelasTrainer',
            'getTotalAbsenRecapOnTrainer',
            'getCountTotalGaji',
            'getAccountTrainer',
            'getAccountUser',
            'getAccountUserHasDeleted',
            'getScheduleOnClassAndTotalTime',
            'countAkunTrainer',
            'getSallaryReports',
            'getAbsenOfTrainer',
            'getRingkasanJadwal',
            'getStatistikJadwalKelasPerTrainer',
            'getStatistikJadwalKelasPerHari',
            'getAnalisisAbsensi',
        ));
    }

    private function countSallaryAndLevels()
    {
        return Level_trainer::get()
            ->count();
    }

    private function countKelasOfKurikulum()
    {
        return Kelas::get()
            ->count();
    }

    private function countKelasHasDeleteOfKurikulum()
    {
        return Kelas::onlyTrashed()
            ->get()
            ->count();
    }

    private function countAssignedClassOfKurikulum()
    {
        return Assigned_kelas_trainer::get()
            ->count();
    }

    private function countAssignedClassHasDeleteOfKurikulum()
    {
        return Assigned_kelas_trainer::onlyTrashed()
            ->get()
            ->count();
    }

    private function countJadwalKelas()
    {
        return Jadwal_kelas::get()
            ->count();
    }

    private function countJadwalKelasHasDelete()
    {
        return Jadwal_kelas::onlyTrashed()
            ->get()
            ->count();
    }

    private function listSemuaAkunTrainer()
    {
        return Trainer::where('roles', 'trainer')
            ->orderByDesc('id')
            ->get();
    }

    private function listSemuaAkunUser()
    {
        return User::where('roles', '!=', 'trainer')
            ->orderByDesc('id')
            ->get();
    }

    private function kurikulumKelas()
    {
        return Kelas::orderByDesc('id')
            ->get();
    }

    private function getTotalSallaryReports()
    {
        return Sallaryreport::get()
            ->count();
    }

    private function getTotalVerifySallaryReports()
    {
        return Sallaryreport::where('status', 'verified')
            ->get()
            ->count();
    }

    private function getTotalUnerifySallaryReports()
    {
        return Sallaryreport::where('status', 'unverified')
            ->get()
            ->count();
    }

    private function getExpandTotalSallaryReports()
    {
        return Sallaryreport::where('status', 'verified')->sum('total_gaji');
    }

    private function getTotalHandleKelasTrainer()
    {
        return Assigned_kelas_trainer::where('users_id', Auth::guard('user')->user() ? Auth::guard('user')->user()->id : 0)
            ->get()
            ->count();
    }

    private function getTotalAbsenRecapOnTrainer()
    {
        return Absen::where('users_id', Auth::guard('user')->user() ? Auth::guard('user')->user()->id : 0)
            ->get()
            ->count();
    }

    private function getCountTotalGaji(): array
    {
        return array(
            'verified' => Sallaryreport::where('status', 'verified')
                ->get()->count(),
            'unverified' => Sallaryreport::where('status', 'unverified')
                ->get()
                ->count()
        );
    }

    private function getAccountUser()
    {
        return User::where('roles', '!=', 'trainer')
            ->get()
            ->count();
    }

    private function getAccountTrainer()
    {
        return User::where('roles', 'trainer')
            ->get()
            ->count();
    }

    private function getAccountUserHasDeleted()
    {
        return User::onlyTrashed()
            ->where('roles', '!=', 'trainer')
            ->get()
            ->count();
    }

    private function getScheduleOnClassAndTotalTime()
    {
        return Jadwal_kelas::get()
            ->count();
    }

    private function countAkunTrainer()
    {
        return Trainer::where('roles', 'trainer')
            ->get()
            ->count();
    }

    //dashboard finance
    private function getSallaryReports()
    {
        return Sallaryreport::with(['user', 'assignedKelas', 'kelas'])
            ->orderByDesc('id')
            ->get();
    }

    //dashboard trainer
    private function getAbsenOfTrainer()
    {
        return Absen::where('users_id', Auth::guard('user')->user() ? Auth::guard('user')->user()->id : 0)
            ->with(['jadwal', 'user'])
            ->orderByDesc('id')
            ->get();
    }

    //dashboard hrd
    private function getRingkasanJadwal()
    {
        return Jadwal_kelas::with('kelas')
            ->orderBy('id')
            ->get();
    }

    private function getStatistikJadwalKelasPerTrainer()
    {
        return User::with('AssignedClass')
            ->where('roles', 'trainer')
            ->orderBy('id')
            ->get();
    }

    private function getStatistikJadwalKelasPerHari()
    {
        return Kelas::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "views"')
            ));
    }

    private function getAnalisisAbsensi()
    {
        return User::whereroles('trainer')
            ->orderByDesc('id')
            ->with('absen')
            ->get();
    }
}
