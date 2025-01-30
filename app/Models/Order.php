<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['client_id','order_number','produits','reduction','acompte','prix_total','mode_achat','client_id','produit_id'];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
