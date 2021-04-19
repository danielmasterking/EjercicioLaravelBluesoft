<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    protected $table = 'movimientos';
    protected $fillable = ['numero_cuenta','valor','tipo'];
}
