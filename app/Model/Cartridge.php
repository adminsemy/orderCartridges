<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cartridge extends Model
{
    protected $table = 'web_tovari';

    protected $fillable = [
        'id', 'marka'
    ];
    
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
    
    /**
     * Returns the relationship with the model PrinterName
     *
     * @return BelongsToMany
     */
    public function printerName(): BelongsToMany
    {
        return $this->belongsToMany('App\Model\PrinterNames', 'web_cartridge', 'id_tovari', 'id_orgtekhnika');
    }
}