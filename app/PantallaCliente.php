<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PantallaCliente extends Model
{
    protected $guarded = [];

    public function pantallas(){
        return $this->hasMany(Pantalla::class);
    }
}
