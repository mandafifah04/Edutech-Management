<?php

namespace App\Http\Controllers\Dashboard\Hrd;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Jadwal_kelas;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class ScheduleClassTrainerController extends Controller
{
    const STATUS_KELAS = ['private', 'regular'];

    public function scheduleClass(Request $request)
    {
        try {
            return $this->ViewListClassOfSchedule($this->getKelas($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function detailScheduleClass($id_kelas, Request $request)
    {
        try {
            return $this->ShowListClassOfSchedule($id_kelas, $this->getScheduleOfClass($id_kelas, $request), static::STATUS_KELAS, $this->getKelas($request), $this->getTrashSchedule($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    /** algoritma/procedure func/handler create jadwal
     * 1. validasi input yang dibutuhkan untuk membuat jadwal kelas pada trainer
     * 2. kita lakukan try catch untuk mengetahui apakah statement logic yang dijalankan berhasil atau error(gagal)
     *      jika error pada statement logic yang dijalankan maka error tersebut akan di tangkap oleh catch 
     *      dan langsung di tampilkan pesan errornya secara real time
     * 3. validasi jadwal sebelum di lakukan create(yang artinya ketika jadwal sudah dibuat sebelumnya maka akan menampilkan pesan error)
     * 4. jalankan pesan error yang isi pesan errornya adalah jadwal sudah ada(jadwal untuk kelas sudah di buat)
     * 5. validasi jadwal ketika jadwal belum sama sekali dibuat( artinya jika jadwal belum dibuat sama sekali maka buat jadwal)
     * 6. membuat jadwal yang dimana, data jadwal di ambil dari request input yang telah divalidasi success
     * 7. setelah berhasil buat jadwal selanjutnya tampilkan pesan sukses buat jadwal (dengan pesan berhasil membuat data jadwal kelas)
     */
    public function buatScheduleTrainer(Request $request)
    {
        $this->validasiRequestInputFormBuatScheduleTrainer($request);

        try {
            if ($this->ValidateEditOrCreateJadwalForClass($request)) {
                return $this->getResponseAfterCreateScheduleError();
            }

            if (!$this->ValidateEditOrCreateJadwalForClass($request)) {
                $this->masukanRequestInputFormBuatScheduleTrainer($this->requestInputFormBuatScheduleTrainer($request));
                return $this->Response('Berhasil Membuat Data Jadwal Kelas', 'hrd.trainer.schedule.list');
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function ubahScheduleTrainer(Request $request): RedirectResponse
    {
        $this->validasiRequestInputFormUbahScheduleTrainer($request);

        try {
            if ($this->checkIdUpdateScheduleTrainer($request)) {
                if ($this->ValidateEditOrCreateJadwalForClass($request)) {
                    return $this->getResponseAfterUpdateScheduleError($request);
                }

                if (!$this->ValidateEditOrCreateJadwalForClass($request)) {
                    $this->masukanRequestInputFormUpdateScheduleTrainer($this->requestInputFormUpdateScheduleTrainer($request));
                    return $this->Response('Berhasil Mengubah Data Jadwal Kelas', 'hrd.trainer.schedule.detail.list', 'success', ['id_kelas' => $request->kelas_id]);
                }
            } else {
                return $this->Response('Id schedule salah', 'hrd.trainer.schedule.list', 'error', ['id_kelas' => $request->kelas_id]);
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function hapusScheduleTrainer($id_kelas, $id_jadwal): RedirectResponse
    {
        try {

            if ($this->checkIdDeleteScheduleTrainer($id_jadwal)) {
                $this->masukanRequestInputFormHapusScheduleTrainer($id_jadwal);
                return $this->Response('Berhasil Menghapus Data Jadwal Kelas', 'hrd.trainer.schedule.detail.list', 'success', ['id_kelas' => $id_kelas]);
            } else {
                return $this->Response('Id schedule salah', 'hrd.trainer.schedule.detial list', 'error', ['id_kelas' => $id_kelas]);
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function restoreByID($id, $id_kelas): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'hrd.trainer.schedule.detail.list', 'success', ['id_kelas' => $id_kelas]);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.schedule.detail.list', 'error', ['id_kelas' => $id_kelas]);
        }
    }

    public function restoreAll($id_kelas): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'hrd.trainer.schedule.detail.list', 'success', ['id_kelas' => $id_kelas]);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.schedule.detail.list', 'error', ['id_kelas' => $id_kelas]);
        }
    }

    public function deleteByID($id, $id_kelas): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'hrd.trainer.schedule.detail.list', 'success', ['id_kelas' => $id_kelas]);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.schedule.detail.list', 'error', ['id_kelas' => $id_kelas]);
        }
    }

    public function deleteAll($id_kelas): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'hrd.trainer.schedule.detail.list', 'success', ['id_kelas' => $id_kelas]);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'hrd.trainer.schedule.detail.list', 'error', ['id_kelas' => $id_kelas]);
        }
    }

    private function getTrashSchedule($request)
    {
        return Jadwal_kelas::onlyTrashed()
            ->with('kelas')
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas_trash}%");
            })
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('status_kelas', 'like', "%{$request->status_kelas_trash}%");
            })
            ->when($request->hari_jadwal_kelas_trash, function ($query) use ($request) {
                $query->where('hari_jadwal_kelas', 'like', "%{$request->hari_jadwal_kelas_trash}%");
            })
            ->when($request->tanggal_jadwal_kelas_trash, function ($query) use ($request) {
                $query->where('tanggal_jadwal_kelas', 'like', "%{$request->tanggal_jadwal_kelas_trash}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function doRestoreByID($id): void
    {
        Jadwal_kelas::onlyTrashed()->where('id', $id)->restore();
    }

    private function doRestoreAll(): void
    {
        Jadwal_kelas::onlyTrashed()->restore();
    }

    private function doDeleteByID($id): void
    {
        Jadwal_kelas::onlyTrashed()->where('id', $id)->forceDelete();
    }

    private function doDeleteAll(): void
    {
        Jadwal_kelas::onlyTrashed()->forceDelete();
    }

    private function ValidateEditOrCreateJadwalForClass($request)
    {
        return Jadwal_kelas::where([
            ['kelas_id', '=', $request['kelas_id']],
            ['tanggal_jadwal_kelas', '=', $request['tanggal_jadwal_kelas']],
            ['jam_mulai_jadwal_kelas', '=', $request['jam_mulai_jadwal_kelas']],
        ])->first();
    }

    private function getResponseAfterCreateScheduleError()
    {
        return $this->Response('Jadwal sudah ada', 'hrd.trainer.schedule.list', 'error');
    }
    private function getResponseAfterUpdateScheduleError($request)
    {
        return $this->Response('Jadwal sudah ada', 'hrd.trainer.schedule.detail.list', 'error', ['id_kelas' => $request->kelas_id]);
    }

    /**
     * input yang di validasi adalah
     * 1. hari dengan tipe string dan tidak required
     * 2. tanggal pada jadwal kelas dengan tipe required dan format tanggal(y-m-d (year)(month)(date))
     * 3. kelas_id input relasi untuk jadwal yang akan di handle oleh kelas nya (yang artinya jadwal yang di create/buat untuk kelas apa)
     * 4. jam mulai kelas dengan tipe format waktu (h:i (hour, minute)) dan required
     * 5. jam akhir kelas denga tipe format required waktu (h:i (hour, minute))
     * 6. pertemuan kelas dengan format integer dan required (required adalah wajib untuk di isi dan tidak bisa di kosongkan)
     */
    private function validasiRequestInputFormBuatScheduleTrainer($request)
    {
        return $request->validate([
            'hari_jadwal_kelas' => 'string',
            'tanggal_jadwal_kelas' => 'required|date:Y-m-d',
            'kelas_id' => 'required|string',
            'jam_mulai_jadwal_kelas' => 'date_format:H:i|required',
            'jam_akhir_jadwal_kelas' => 'date_format:H:i',
            'pertemuan_kelas' => 'integer|required'
        ], [
            // custom format (error response (pesan error) validasi bisa di atur sesuai dengan kebutuhan kita)
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function validasiRequestInputFormUbahScheduleTrainer($request)
    {
        return $request->validate([
            'hari_jadwal_kelas' => 'string',
            'tanggal_jadwal_kelas' => 'date:Y-m-d',
            'kelas_id' => 'integer',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function requestInputFormBuatScheduleTrainer($request): array
    {
        $MapRequest = $request->only('kelas_id', 'hari_jadwal_kelas', 'tanggal_jadwal_kelas', 'jam_mulai_jadwal_kelas', 'jam_akhir_jadwal_kelas');
        return $this->_GetPertemuan($MapRequest, $request);
    }

    private function _SetPertemuan($Req, $request): array
    {
        // ambil dari tanggal mulai pertemuan
        $SetCarboDays = Carbon::createFromFormat('Y-m-d', $Req['tanggal_jadwal_kelas']);
        $Week = [];
        // iterasi loop berjalan hingga batas pertemuan/pertemuan akhir (3 pertemuan) maka iteration lopp berjalan
        // dari pertemuan pertama hingga pertemuan ke 3
        for ($Meets = 0; $Meets <= $request->pertemuan_kelas; $Meets++) {
            // mengambil fungsi kondisi pertemuan tiap weeknya agar tanggal pertemuan yang di set
            // sesuai dengan tanggal mulai pertemuan
            switch ($Meets) {
                case 0:
                    $Tanggal = array('tanggal_jadwal_kelas' => $SetCarboDays->addWeek($Meets)->format('Y-m-d'));
                    $Week[] = array_merge($Req, $Tanggal);
                    break;
                default:
                    $Tanggal = array('tanggal_jadwal_kelas' => $SetCarboDays->addWeek(1)->format('Y-m-d'));
                    $Week[] = array_merge($Req, $Tanggal);
                    break;
            }
        }

        return $Week;
    }

    private function _GetPertemuan($MapRequest, $request): array
    {
        $MapRequest['hari_jadwal_kelas'] = Carbon::parse($MapRequest['tanggal_jadwal_kelas'])->dayName;
        $MapRequest['jam_akhir_jadwal_kelas'] = Carbon::parse($MapRequest['jam_mulai_jadwal_kelas'])->addHour(2)->format('H:i');
        return $this->_SetPertemuan($MapRequest, $request);
    }

    private function requestInputFormUpdateScheduleTrainer($request): array
    {
        $Req = $request->only('id', 'kelas_id', 'hari_jadwal_kelas', 'tanggal_jadwal_kelas', 'jam_mulai_jadwal_kelas', 'jam_akhir_jadwal_kelas');
        $Req['hari_jadwal_kelas'] = Carbon::parse($Req['tanggal_jadwal_kelas'])->dayName;
        $Req['jam_akhir_jadwal_kelas'] = Carbon::parse($Req['jam_mulai_jadwal_kelas'])->addHour(2)->format('H:i');
        return $Req;
    }

    private function masukanRequestInputFormBuatScheduleTrainer($requestInputFormBuatScheduleTrainer): void
    {
        foreach ($requestInputFormBuatScheduleTrainer as $reqInputFormBuatScheduleTrainer) {
            Jadwal_kelas::create([
                'kelas_id' => $reqInputFormBuatScheduleTrainer['kelas_id'],
                'hari_jadwal_kelas' => $reqInputFormBuatScheduleTrainer['hari_jadwal_kelas'],
                'tanggal_jadwal_kelas' => $reqInputFormBuatScheduleTrainer['tanggal_jadwal_kelas'],
                'jam_mulai_jadwal_kelas' => $reqInputFormBuatScheduleTrainer['jam_mulai_jadwal_kelas'],
                'jam_akhir_jadwal_kelas' => $reqInputFormBuatScheduleTrainer['jam_akhir_jadwal_kelas'],
            ]);
        }
    }

    private function masukanRequestInputFormUpdateScheduleTrainer($request): void
    {
        Jadwal_kelas::where('id', $request['id'])->update($request);
    }

    private function masukanRequestInputFormHapusScheduleTrainer($id): void
    {
        Jadwal_kelas::where('id', $id)->delete();
    }

    private function checkIdUpdateScheduleTrainer($request): bool
    {
        return Jadwal_kelas::where('id', $request['id'])->first() ? true : false;
    }
    private function checkIdDeleteScheduleTrainer($id): bool
    {
        return Jadwal_kelas::where('id', $id)->first() ? true : false;
    }

    private function getScheduleOfClass($id_kelas, $request)
    {
        return Jadwal_kelas::where('kelas_id', $id_kelas)
            ->with('kelas')
            ->orderByDesc('id')
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas}%");
            })
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('status_kelas', 'like', "%{$request->status_kelas}%");
            })
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('status_kelas', 'like', "%{$request->status_kelas}%");
            })
            ->when($request->hari_jadwal_kelas, function ($query) use ($request) {
                $query->where('hari_jadwal_kelas', 'like', "%{$request->hari_jadwal_kelas}%");
            })
            ->when($request->tanggal_jadwal_kelas, function ($query) use ($request) {
                $query->where('tanggal_jadwal_kelas', 'like', "%{$request->tanggal_jadwal_kelas}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function getKelas($request)
    {
        return Kelas::with(['levelTrainer', 'jadwalKelas'])
            ->when($request->nama_kelas, function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas}%");
            })
            ->when($request->status_kelas, function ($query) use ($request) {
                $query->where('status_kelas', 'like', "%{$request->status_kelas}%");
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at}%");
            })
            ->whereHas('levelTrainer', function ($query) use ($request) {
                $query->where('sallary_level', 'like', "%{$request->sallary_kelas}%");
            })
            ->orderByDesc('id')
            ->get();
    }

    private function ViewListClassOfSchedule($getKelas): View
    {
        return view('dashboard.hrd.schedule_class_trainer', compact('getKelas'));
    }
    private function ShowListClassOfSchedule($id_kelas, $getScheduleOfClass, $status_kelas, $getKelas, $getTrashSchedule): View
    {
        return view('dashboard.hrd.detail_schedule_class_trainer', compact('id_kelas', 'getScheduleOfClass', 'status_kelas', 'getKelas', 'getTrashSchedule'));
    }
}
