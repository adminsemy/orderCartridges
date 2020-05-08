<?php

namespace App\Http\Resources;

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
            'name' => $this->printerName->name,
            'serialNumber' => $this->serial,
            'inventoryNumber' => $this->inventory_number,
            'uin' => $this->users,
            'cartridges' => CartridgesOfPrinterResource::collection($this->cartridges),
            'history' => HistoryOrderResource::collection($this->historyOrder)
        ];
    }
}
