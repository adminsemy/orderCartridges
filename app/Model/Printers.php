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
}
