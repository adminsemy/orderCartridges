<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoryOrder extends Model
{
    const NEW_CARTRIDGE = 'new';
    const SEASONED_CARTRIDGE = 'seasoned';
    const GIVE_NEW = 1;
    const GIVE_SEASONED = 2;
    const ORDER_COMPLITED = 1;

    protected $table = 'web_zakaz';

    public function cartridge()
    {
        return $this->belongsTo('App\Model\Cartridge', 'id_cartridge');
    }

    public function printer()
    {
        return $this->belongsTo('App\Model\Printers', 'id_tehniki');
    }
}
