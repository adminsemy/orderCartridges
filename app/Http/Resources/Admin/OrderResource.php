<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'cartridgeName' => $this->cartridge->marka,
            'printerName' => $this->printer->printerName->name,
            'newCartridge' => $this->cartridge->all,
            'date' => $this->data,
            'action' => $this->action
        ];
    }
}
