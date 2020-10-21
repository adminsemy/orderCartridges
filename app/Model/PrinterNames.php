<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrinterNames extends Model
{
    protected $table = 'web_brands';

    protected $fillable = [
        'id', 'name'
    ];
    
    public function printer()
    {
        return $this->hasMany('App\Model\Printers', 'id_name');
    }

    public function cartridgesOfPrinter()
    {
        return $this->hasMany('App\Model\CartridgesOfPrinter', 'id_orgtekhnika');
    }
}
