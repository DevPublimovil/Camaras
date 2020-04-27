<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PantallaClienteResource extends JsonResource
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
            'id' => $this->pantalla->id,
            'name' => $this->pantalla->name,
        ];
    }
}
