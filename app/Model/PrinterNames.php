<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrinterNames extends Model
{
    protected $table = 'web_orgtekhnika_name';

    public function printer()
    {
        return $this->hasOne('App\Model\Printers', 'id_name');
    }

    public function cartridgesOfPrinter()
    {
        return $this->belongsTo('App\Model\CartridgesOfPrinter', 'id_orgtekhnika');
    }
}
