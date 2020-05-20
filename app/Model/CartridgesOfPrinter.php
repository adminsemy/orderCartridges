<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartridgesOfPrinter extends Model
{
    protected $table = 'web_cartridge';

    public function printer()
    {
        return $this->hasOne('App\Model\Printers', 'id_orgtekhnika', 'id_name');
    }

    public function cartridge()
    {
        return $this->belongsTo('App\Model\Cartridge', 'id_tovari');
    }

}
