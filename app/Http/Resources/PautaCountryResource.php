<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PautaCountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'paises' => $this->pantallas()->select('countries.*')->join('pantallas','pantallas.id','pantalla_clientes.pantalla_id')->join('countries','countries.id','pantallas.country_id')->groupBy()->get()
        ];
    }
}
