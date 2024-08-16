<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $table = 'kelas';

    protected $fillable = ['uid_class', 'nama_kelas', 'status_kelas', 'level_trainers_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'uid_class' => 'string',
        'kode_kelas' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    use HasFactory;

    public function AssignedClassTrainer(): HasOne
    {
        return $this->hasOne(Assigned_kelas_trainer::class, 'kelas_id', 'id');
    }

    public function levelTrainer(): HasOne
    {
        return $this->hasOne(Level_trainer::class, 'id', 'level_trainers_id');
    }

    public function jadwalKelas(): HasMany
    {
        return $this->hasMany(Jadwal_kelas::class, 'kelas_id', 'id');
    }

    // jadwal absen dari kelas
    public function absens(): HasMany
    {
        return $this->hasMany(Absen::class, 'kelas_id', 'id');
    }

    //cek apakah gaji dari kelas sudah di submit
    public function sallaryReports(): HasOne
    {
        return $this->hasOne(Sallaryreport::class, 'kelas_id', 'id');
    }

    public function jadwalKelass(): HasOne
    {
        return $this->hasOne(Jadwal_kelas::class, 'kelas_id', 'id');
    }
}
