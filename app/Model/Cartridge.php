<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    
    /**
     * Returns the relationship with the model Brands across 
     * the model CartridgesOfPrinter
     *
     * @return HasMany
     */
    public function brandsOfCartridge(): HasMany
    {
        return $this->hasMany('App\Model\CartridgesOfPrinter', 'id_tovari');
    }
}