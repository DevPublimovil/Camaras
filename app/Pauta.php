<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pauta extends Model
{
    protected $guarded = [];

    public function vendedor()
    {
        return $this->belongsTo('App\User', 'vendedor_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo('App\User', 'cliente_id', 'id');
    }

    public function pantallas()
    {
        return $this->hasMany('App\PantallaCliente', 'pauta_id', 'id');
    }
}
