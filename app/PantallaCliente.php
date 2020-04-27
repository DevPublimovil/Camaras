<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PantallaCliente extends Model
{
    protected $guarded = [];

    public function pantallas(){
        return $this->hasMany(Pantalla::class);
    }

    public function pantalla()
    {
        return $this->belongsTo('App\Pantalla', 'pantalla_id', 'id');
    }
    
    public function cliente()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function vendedor()
    {
        return $this->belongsTo('App\User', 'vendedor_id', 'id');
    }
}
