<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Printers extends Model
{
    protected $table = "web_orgtekhnika";

    protected $fillable = [
        'id', 'inventory_number', 'serial',
    ];

    public function printerName()
    {
        return $this->belongsTo('App\Model\PrinterNames', 'id_name');
    }

    public function cartridges()
    {
        return $this->hasMany('App\Model\CartridgesOfPrinter', 'id_orgtekhnika', 'id_name');
    }

    public function historyOrder()
    {
        return $this->hasMany('App\Model\HistoryOrder', 'id_tehniki');
    }
}
