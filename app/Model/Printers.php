<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Printers extends Model
{
    protected $table = "web_orgtekhnika ";

    public function printerName()
    {
        return $this->belongsTo('App\Model\PrinterNames', 'id_name');
    }
}
