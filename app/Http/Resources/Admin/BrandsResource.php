<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\CartridgesOfPrinterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandsResource extends JsonResource
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
            'name' => $this->name,
            'cartridge' => CartridgesOfPrinterResource::collection($this->cartridgesOfPrinter)
        ];
    }
}
