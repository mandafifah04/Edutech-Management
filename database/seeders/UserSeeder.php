<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'hrduser',
            'username' => 'hrd',
            'email' => 'hrdexample@gmail.com',
            'password' => Hash::make('12345'),
            'roles' => 'hrd',
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
            'updated_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ]);

        DB::table('users')->insert([
            'name' => 'kurikulum',
            'username' => 'kurikulum',
            'email' => 'kulikum@gmail.com',
            'password' => Hash::make('12345'),
            'roles' => 'kurikulum',
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ]);

        DB::table('users')->insert([
            'name' => 'trainer',
            'username' => 'trainer',
            'email' => 'trainer@gmail.com',
            'password' => Hash::make('12345'),
            'roles' => 'trainer',
            'level_trainers_id' => 1,
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ]);

        DB::table('users')->insert([
            'name' => 'keuangan',
            'username' => 'keuangan',
            'email' => 'keuangan@gmail.com',
            'password' => Hash::make('12345'),
            'roles' => 'keuangan',
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ]);
    }
}
