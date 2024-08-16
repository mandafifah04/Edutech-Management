<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level_trainer extends Model
{
    use SoftDeletes;

    protected $fillable = ['kode_level', 'nama_level', 'sallary_level', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'kode_level' => 'string',
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    use HasFactory;
}
