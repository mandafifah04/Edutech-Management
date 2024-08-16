<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal_kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_kelas';

    protected $fillable = ['kelas_id', 'hari_jadwal_kelas', 'tanggal_jadwal_kelas', 'jam_mulai_jadwal_kelas', 'jam_akhir_jadwal_kelas', 'status', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
}
