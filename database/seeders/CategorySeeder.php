<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insertOrIgnore([
            'id'=>1,
            'nom'=>'Téléphones',
            'description'=>'Catégorie englobant tout les produits téléphoniques',
        ]);
        DB::table('categories')->insertOrIgnore([
            'id'=>2,
            'nom'=>'Accessoires',
            'description'=>'Catégorie englobant tout les accessoires',
        ]);
    }
}
