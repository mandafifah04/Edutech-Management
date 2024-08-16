<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Admin Alsav',
            'username' => 'adminalsav',
            'email' => 'adminalsav@gmail.com',
            'password' => Hash::make('1234567890'),
            'roles' => 'admin',
            'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'UTC')),
        ]);


    }
}
