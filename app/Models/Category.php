<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['nom','photo'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'categorie_id');
    }
    public function products()
    {
        return $this->hasManyThrough(Produit::class, SubCategory::class, 'categorie_id', 'subcategory_id');
    }
}
