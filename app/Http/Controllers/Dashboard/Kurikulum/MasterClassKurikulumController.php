<?php

namespace App\Http\Controllers\Dashboard\Kurikulum;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Level_trainer;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MasterClassKurikulumController extends Controller
{
    const STATUS_KELAS = ['private', 'regular'];

    public function kelas(Request $request)
    {
        try {
            return $this->viewListkelas($this->getKelas($request), $this->getLevelTrainer(), static::STATUS_KELAS, $this->getTrashByKelas($request));
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function buatKelas(Request $request): RedirectResponse
    {
        $this->validationRequestInputFormCreateKelas($request);

        try {
            if ($this->validateAlreadyExitstOfKelas($request)) {
                return $this->getResponseValidateAlreadyExitstOfKelas();
            }

            if (!$this->validateAlreadyExitstOfKelas($request)) {
                $this->requestInputFormCreateKelas($this->submitInputFormCreateKelas($request));

                return $this->Response('Berhasil Membuat Data Kelas', 'kurikulum.kelas.list');
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function ubahKelas(Request $request): RedirectResponse
    {
        $this->validationRequestInputFormUpdateKelas($request);

        try {
            if ($this->validateAlreadyExitstOfKelas($request)) {
                return $this->getResponseValidateAlreadyExitstOfKelas();
            }

            if (!$this->validateAlreadyExitstOfKelas($request)) {
                if ($this->checkIdUpdateKelas($request)) {
                    $this->requestInputFormUpdateKelas($this->SubmitInputFormUpdateClass($request));
                    return $this->Response('Berhasil Mengubah Data Kelas', 'kurikulum.kelas.list');
                } else {
                    return $this->Response('Id schedule salah', 'kurikulum.kelas.list', 'error');
                }
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function hapusKelas(Kelas $id): RedirectResponse
    {
        try {

            if ($this->checkIdDeleteKelas($id->id)) {
                $this->requestDeleteKelas($id->id);
                return $this->Response('Berhasil Menghapus Data Kelas', 'kurikulum.kelas.list');
            } else {
                return $this->Response('Id schedule salah', 'kurikulum.kelas.list', 'error');
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function restoreByID($id): RedirectResponse
    {
        try {
            $this->doRestoreByID($id);
            return $this->Response('Berhasil Mengembalikan Data', 'kurikulum.kelas.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.kelas.list', 'error');
        }
    }

    public function restoreAll(): RedirectResponse
    {
        try {
            $this->doRestoreAll();
            return $this->Response('Berhasil Mengembalikan Semua Data', 'kurikulum.kelas.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.kelas.list', 'error');
        }
    }

    public function deleteByID($id): RedirectResponse
    {
        try {
            $this->doDeleteByID($id);
            return $this->Response('Berhasil Menghapus Data', 'kurikulum.kelas.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.kelas.list', 'error');
        }
    }

    public function deleteAll(): RedirectResponse
    {
        try {
            $this->doDeleteAll();
            return $this->Response('Berhasil Menghapus Semua Data', 'kurikulum.kelas.list');
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'kurikulum.kelas.list', 'error');
        }
    }

    private function doRestoreByID($id): void
    {
        Kelas::onlyTrashed()->whereId($id)->restore();
    }

    private function doRestoreAll(): void
    {
        Kelas::onlyTrashed()->restore();
    }

    private function doDeleteByID($id): void
    {
        Kelas::onlyTrashed()->whereId($id)->forceDelete();
    }

    private function doDeleteAll(): void
    {
        Kelas::onlyTrashed()->forceDelete();
    }

    private function validationRequestInputFormCreateKelas($request)
    {
        return $request->validate([
            'nama_kelas' => 'required|string',
            'status_kelas' => 'required|in:private,regular',
            'level_trainers_id' => 'required|integer',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function validationRequestInputFormUpdateKelas($request)
    {
        return $request->validate([
            'nama_kelas' => 'string',
            'status_kelas' => 'in:private,regular',
            'level_trainers_id' => 'integer',
        ]);
    }

    private function validateAlreadyExitstOfKelas($request)
    {
        return Kelas::where([
            ['nama_kelas', '=', $request['nama_kelas']],
            ['status_kelas', '=', $request['status_kelas']],
            ['level_trainers_id', '=', $request['level_trainers_id']],
        ])->first();
    }

    private function getResponseValidateAlreadyExitstOfKelas()
    {
        return $this->Response('Kelas sudah ada', 'kurikulum.kelas.list', 'error');
    }

    private function requestFormCreateKelas($request): array
    {
        return $request->only('uid_class', 'level_trainers_id', 'nama_kelas', 'status_kelas');
    }

    private function generateKodeKelas($data)
    {
        // Get the prefix from the class name
        $firstLetter = strtoupper(mb_substr($data->nama_kelas, 0, 1));

        // Generate the numeric part of the ID with the prefix
        $GetCustomCodeByKodeKelas = IdGenerator::generate([
            'table' => 'kelas',   // The table name
            'field' => 'uid_class',      // The field name of the auto-incrementing ID
            'length' => 5,        // Total length of the ID including prefix
            'prefix' => $firstLetter,
            'reset_on_prefix_change' => true // Optional: reset the counter on prefix change
        ]);

        return $GetCustomCodeByKodeKelas;
    }

    private function submitInputFormCreateKelas($request)
    {
        $req = $this->requestFormCreateKelas($request);
        $req['uid_class'] = $this->generateKodeKelas($request); // generate code class
        return $req;
    }

    private function SubmitInputFormUpdateClass($request)
    {
        $ReqUpdate = $this->requestFormUpdateKelas($request);
        $ReqUpdate['uid_class'] = $this->generateKodeKelas($request); // generate code class
        return $ReqUpdate;
    }

    private function requestFormUpdateKelas($request): array
    {
        return $request->only('id', 'uid_class', 'nama_kelas', 'status_kelas', 'level_trainers_id');
    }

    private function requestInputFormCreateKelas($request): void
    {
        Kelas::create($request);
    }

    private function requestInputFormUpdateKelas($request): void
    {
        Kelas::where('id', $request['id'])->update($request);
    }

    private function requestDeleteKelas($id): void
    {
        Kelas::where('id', $id)->delete();
    }

    private function checkIdUpdateKelas($request): bool
    {
        return Kelas::where('id', $request['id'])->first() ? true : false;
    }
    private function checkIdDeleteKelas($id): bool
    {
        return Kelas::where('id', $id)->first() ? true : false;
    }

    private function getTrashByKelas($request)
    {
        return Kelas::onlyTrashed()
            ->with(['levelTrainer', 'jadwalKelas'])
            ->when($request->nama_kelas_trash, function ($query) use ($request) {
                $query->where('nama_kelas', 'like', "%{$request->nama_kelas_trash}%");
            })
            ->when($request->status_kelas_trash, function ($query) use ($request) {
                $query->where('status_kelas', 'like', "%{$request->status_kelas_trash}%");
            })
            ->when($request->created_at_trash, function ($query) use ($request) {
                $query->where('created_at', 'like', "%{$request->created_at_trash}%");
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

    private function getLevelTrainer()
    {
        return Level_trainer::orderByDesc('id')->get();
    }

    private function viewListkelas($kelas, $level_trainer, $statusKelas, $getTrashByKelas): View
    {
        return view('dashboard.kurikulum.kelas', compact('kelas', 'level_trainer', 'statusKelas', 'getTrashByKelas'));
    }
}
