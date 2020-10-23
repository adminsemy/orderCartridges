<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CartridgeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->marka,
            'brands' => BrandNameResource::collection($this->brandsOfCartridge),
            'all' => $this->all,
            'ordered' => $this->zakaz,
        ];
    }
}
