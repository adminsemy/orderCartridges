<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrinterNames extends Model
{
    protected $table = 'web_orgtekhnika_name';

    public function printer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
    return $this->hasOne('App\Model\Printers', 'id_name');
    }

    public function cartridgesOfPrinter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Model\CartridgesOfPrinter', 'id_orgtekhnika');
    }
}
