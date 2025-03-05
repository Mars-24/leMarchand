<?php

namespace Database\Seeders;

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
            'nom'=>'lemarchand',
            'prenoms'=>'yannick',
            'email'=>'lemarchand228@gmail.com',
            'role'=>'admin',
            'status'=>'actif',
            'password'=>Hash::make('gestion2025'),
        ]);
        DB::table('admins')->insertOrIgnore([
            'id'=>2,
            'nom'=>'admin',
            'prenoms'=>'yannick',
            'email'=>'admin@gmail.com',
            'role'=>'otr',
            'status'=>'actif',
            'password'=>Hash::make('gestion2025'),
        ]);
    }
}
