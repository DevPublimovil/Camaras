<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = [];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function pantallas()
    {
        return $this->hasMany('App\Pantallas', 'country_id', 'id');
    }
}
