<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absen extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['jadwal_kelas_id', 'kelas_id', 'users_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public function jadwal(): HasOne
    {
        return $this->hasOne(Jadwal_kelas::class, 'id', 'jadwal_kelas_id');
    }

    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }
}
