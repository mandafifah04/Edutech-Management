<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assigned_kelas_trainer extends Model
{
    use SoftDeletes;

    protected $fillable = ['kelas_id', 'users_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    use HasFactory;

    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }
}
