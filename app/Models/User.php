<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'level_trainers_id',
        'roles',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function levelTrainer(): HasOne
    {
        return $this->hasOne(Level_trainer::class, 'id', 'level_trainers_id');
    }

    //untuk submit sallary reports dari hrd ke finance
    public function AssignedClass(): HasMany
    {
        return $this->hasMany(Assigned_kelas_trainer::class, 'users_id', 'id');
    }

    public function absen(): HasMany
    {
        return $this->hasMany(Absen::class, 'users_id', 'id');
    }
}
