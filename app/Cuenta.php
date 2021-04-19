<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuenta';
    protected $fillable = ['numero_cuenta','nombre','saldo'];

}
