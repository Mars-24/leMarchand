<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable =['model','photo','prix_achat','prix_vente','prix_minimum','quantite','garantie','status','code_bar','fournisseur_id','subcategory_id'];
            
}
