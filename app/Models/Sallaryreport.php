<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sallaryreport extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'kelas_id',
        'total_gaji',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'kode_trainer' => 'string',
        'tanggal' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function assignedKelas(): HasOne
    {
        return $this->hasOne(Assigned_kelas_trainer::class, 'users_id', 'users_id');
    }

    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
}
