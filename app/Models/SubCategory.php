<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable=['nom','categorie_id'];

    public function categorie(){
        return $this->belongsTo(Category::class);
    }
    public function produits(){
        return $this->hasMany(Produit::class);
    }

    public function products()
    {
        return $this->hasMany(Produit::class, 'subcategory_id');
    }
}
