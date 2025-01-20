<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pedido extends Model
{
    //
    protected $fillable = [
        'producto',
        'cantidad',
        'total',
        'user_id'
    ];

    //funcion para relacionar pedidos a usuarios 
    public function user(){
        return $this->belongsTo(User::class);
    }
}
