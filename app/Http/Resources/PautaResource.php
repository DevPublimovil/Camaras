<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PantallaCliente;

class PautaResource extends JsonResource
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
            'id'                => $this->id,
            'title'             => ($this->titulo == null) ? $this->cliente->name : $this->titulo,
            'start'             => $this->start_date,
            'end'               => $this->end_date,
            'vendedor'          => $this->vendedor->name,
            'npantallas'        => count($this->pantallas),
            'backgroundColor'   => "#FF5733",
            'textColor'         => "#FFFF"
        ];
    }
}
