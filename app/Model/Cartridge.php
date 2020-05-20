<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cartridge extends Model
{
    protected $table = 'web_tovari';
    
    /**
     * Checks for new cartridges
     *
     * @param  int $id_cartridge
     * @return bool
     */
    public function isNewCartridge(): bool
    {
        if ($this->all === 0) {
            return false;
        } else {
            return true;
        }
    }
}