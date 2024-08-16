<?php

namespace App\Exports;

use App\Models\Absen;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RecapAbsenTrainerExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    private $absen;

    public function __construct(Absen $absen)
    {
        $this->absen = $absen;
    }

    public function collection()
    {
        return $this->absen
            ->whereusers_id(Auth::guard('user')->user()->id)
            ->with(['user', 'jadwal'])
            ->orderByDesc('id')
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->user->name,
            $row->jadwal->kelas->nama_kelas,
            $row->jadwal->tanggal_jadwal_kelas,
            $row->jadwal->jam_mulai_jadwal_kelas,
            $row->jadwal->jam_akhir_jadwal_kelas,
            $row->jadwal->hari_jadwal_kelas,
            $row->jadwal->kelas->status_kelas,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Trainer',
            'Kelas',
            'Tanggal',
            'Jam Mulai',
            'Jam Berakhir',
            'Hari',
            'Status Kelas',
        ];
    }
}
