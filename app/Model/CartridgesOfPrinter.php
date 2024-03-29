<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartridgesOfPrinter extends Model
{
    protected $dateFormat;
    protected $table = 'web_cartridge';

    protected $fillable = [
        'id_orgtekhnika', 'id_tovari'
    ];

    public function printer()
    {
        return $this->belongsTo('App\Model\PrinterNames', 'id_orgtekhnika');
    }

    public function cartridge(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Model\Cartridge', 'id_tovari');
    }

}