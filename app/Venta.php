<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User', 'cliente_id','id');
    }
}
