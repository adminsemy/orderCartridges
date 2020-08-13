<?php

namespace App\Services;

use App\Model\CartridgesOfPrinter;
use App\Model\PrinterCartridges\BrandCartridgesDelete;
use App\Model\PrinterCartridges\BrandCartridgesInsert;
use App\Model\PrinterNames;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class for brand and them cartridges
 */
class BrandCartridgesService
{
    public static function save(PrinterNames $brand, Request $request): bool
    {
        $isRemove = false; 
        $isAdded = false;

        $currentBrandCartridges = CartridgesOfPrinter::select('id_tovari as id')
                                    ->where('id_orgtekhnika', $brand->id)
                                    ->get();
        $currentBrandCartridges = self::idCartridge($currentBrandCartridges->toArray());
        
        $idRequestCartriges = self::idCartridge($request->only('cartridges')['cartridges']);
        
        //Array 'id' of cartridges to remove
        $removalCartridges = self::forRemoving(collect($currentBrandCartridges), $idRequestCartriges);
        
        if ($removalCartridges !== []) {
            $isRemove = BrandCartridgesDelete::cartridges((int) $brand->id, $removalCartridges);
        }
        
        //Array 'id' of cartridges left after removal
        $remainingCurrentCartridges =  self::withOutRemoval(collect($currentBrandCartridges), $removalCartridges);
        $remainingRequestCartridges =  self::withOutRemoval(collect($idRequestCartriges), $removalCartridges);
        
        //Array 'id' of cartridges for add without removed
        $addCartridges = self::withOutCurrent($remainingCurrentCartridges, $remainingRequestCartridges);
        
        if ($addCartridges !== []) {
            $isAdded = BrandCartridgesInsert::cartridges((int) $brand->id, $addCartridges);
        }

        if ($isRemove || $isAdded) {
            return true;
        }
        return false;
        
    }
    
    /**
     * Return an array of id of cartridge from a request
     *
     * @param  array $cartridges
     * @return array
     */
    private static function idCartridge(array $cartridges): array
    {
        $idCartridges = array_map(function ($catridge) {
            return (int) $catridge['id'];
        }, array_values($cartridges));

        return array_unique($idCartridges);
    }
    
    /**
     * Returns an array of cartridges that them delete
     *
     * @param  Collection $currentCollection
     * @param  array $removal
     * @return array
     */
    private static function forRemoving(Collection $currentCollection, array $removal): array
    {
        $remainingCartridges = $currentCollection->intersect($removal);
        return $currentCollection->diff($remainingCartridges)->toArray();
    }
    
    /**
     * Deleting removed cartridges from current array and return the result
     *
     * @param  Collection $currentCollection
     * @param  array $removal
     * @return array
     */
    private static function withOutRemoval(Collection $currentCollection, array $removal): array
    {
        return $currentCollection->diff($removal)->toArray();
    }

    /**
     * Deleting current cartridges from reguest array and return the result
     *
     * @param  array $current
     * @param  array $fromRequest
     * @return array
     */
    private static function withOutCurrent(array $current, array $fromRequest): array
    {
        return collect($fromRequest)->diff($current)->toArray();
    }
}
