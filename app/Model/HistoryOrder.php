<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoryOrder extends Model
{
    protected $table = 'web_zakaz';

    public function cartridgeName()
    {
        return $this->belongsTo('App\Model\Cartridge', 'id_cartridge');
    }
}
