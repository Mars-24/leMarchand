<?php

namespace Database\Seeders;

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
        DB::table('admins')->insertOrIgnore([
            'id'=>1,
            'nom'=>'le marchand',
            'prenoms'=>'yannick',
            'email'=>'admin@gmail.com',
            'role'=>'admin',
            'status'=>'actif',
            'password'=>Hash::make('admin'),
        ]);
    }
}
