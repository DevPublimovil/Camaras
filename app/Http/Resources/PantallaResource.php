<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PantallaResource extends JsonResource
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
            'id'        => $this->id,
            'pantalla'  => $this->name,
            'pais'      => $this->country->name
        ];
    }
}
