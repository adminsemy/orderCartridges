<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartridgesOfPrinter extends Model
{
    protected $table = 'web_cartridge';

    public function printer()
    {
        return $this->belongsTo('App\Model\PrinterName', 'id_orgtekhnika');
    }

    public function cartridge(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Model\Cartridge', 'id_tovari');
    }

}