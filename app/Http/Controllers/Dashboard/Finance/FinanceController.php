<?php

namespace App\Http\Controllers\Dashboard\Finance;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Level_trainer;
use App\Models\Sallaryreport;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    const StatusVerify = ['verified', 'unverified'];
    const Month = ['january', 'february', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'novmber', 'desember'];
    public function SallaryReports(Request $request)
    {
        try {
            return $this->ViewSallaryReports($this->GetSallaryReports($request), $this->GetLevelTrainer(), static::StatusVerify, static::Month);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function VerifySallaryReports($id_sallary, $status)
    {
        try {

            if (!$this->CheckVerifySallaryReportsBYID($id_sallary)) {
                return $this->Response('ID Sallary Salah', 'keuangan.reports', 'error');
            }

            if ($this->CheckVerifySallaryReportsBYID($id_sallary)) {
                $this->DoVerifySallaryReports($id_sallary, $status);
                return $this->Response('Berhasil Verify Sallary Trainer', 'keuangan.reports');
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function ExportPdfByRecapSallary(Request $request)
    {
        try {
            return $this->DoExportPdfByRecapSallary($request);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    private function CheckVerifySallaryReportsBYID($id_sallary): bool
    {
        if (Sallaryreport::whereId($id_sallary)->first()) {
            return true;
        }

        return false;
    }

    private function DoVerifySallaryReports($id_sallary, $status): void
    {
        Sallaryreport::whereId($id_sallary)->update(['status' => $status]);
    }

    private function GetLevelTrainer()
    {
        return Level_trainer::orderByDesc('id')->get();
    }


    private function GetSallaryReports($request)
    {
        return Sallaryreport::with(['user', 'kelas'])
            ->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->nama_trainer}%");
            })
            ->whereHas('user.levelTrainer', function ($query) use ($request) {
                $query->where('nama_level', 'like', "%{$request->level_trainer}%");
            })
            ->when($request->status_verified, function ($query) use ($request) {
                $query->where('status', 'like', "%{$request->status_verified}%");
            })
            ->when($request->total_gaji, function ($query) use ($request) {
                $query->where('total_gaji', 'like', "%{$request->total_gaji}%");
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at}%");
            })
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan);
            })
            ->when($request->tahun, function ($query) use ($request) {
                $query->whereYear('created_at', $request->tahun);
            })
            ->when($request->start_at, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_at, $request->end_at]);
            })
            ->orderByDesc('id')
            ->get();
    }

    private function ViewSallaryReports($GetSallaryReports, $GetLevelTrainer, $StatusVerified, $Month): View
    {
        return view('dashboard.finance.sallary_reports', compact('GetSallaryReports', 'GetLevelTrainer', 'StatusVerified', 'Month'));
    }

    private function DoExportPdfByRecapSallary($request)
    {
        $RecapSallaryToPDF = Sallaryreport::with('user')
            ->when($request->start_at, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_at, $request->end_at]);
            })
            ->orderByDesc('id')
            ->get();
        $DoExportSallaryBYPDF = PDF::loadView('dashboard.finance.recap_report_finance', ['RecapSallaryToPDF' => $RecapSallaryToPDF]);
        return $DoExportSallaryBYPDF->download('recap_sallary.pdf');
    }
}
