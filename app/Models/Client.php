<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable=['nom','prenoms','email','telephone','adresse'];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
