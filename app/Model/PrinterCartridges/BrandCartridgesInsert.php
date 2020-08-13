<?php

namespace App\Model\PrinterCartridges;

use App\Model\CartridgesOfPrinter;
use DomainException;
use Illuminate\Support\Facades\DB;

class BrandCartridgesInsert
{    
    /**
     * Inserts cartridges for the brand
     *
     * @param  int $brand
     * @param  array $cartridges
     * @return bool
     */
    public static function cartridges(int $brand, array $cartridges): bool
    {
        try {
            DB::beginTransaction();
            foreach ($cartridges as $idCartridges) {
                CartridgesOfPrinter::insert(['id_orgtekhnika' => $brand, 'id_tovari' => $idCartridges]);
            }
            DB::commit();
            return true;
        } catch(DomainException $e) {
            DB::rollBack();
            return false;
        }
    }
}
