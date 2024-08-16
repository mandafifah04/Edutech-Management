<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelTrainers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('level_trainers')->insert([[
            'kode_level' => uniqid(),
            'nama_level' => 'begineer',
            'sallary_level' => 75000,
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
            'updated_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ], [
            'kode_level' => uniqid(),
            'nama_level' => 'intermediate',
            'sallary_level' => 100000,
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
            'updated_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ], [
            'kode_level' => uniqid(),
            'nama_level' => 'advance',
            'sallary_level' => 500000,
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
            'updated_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ]]);
    }
}
