<?php

namespace App\Services;

use App\Model\CartridgesOfPrinter;
use App\Model\PrinterNames;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class for brand and them cartridges
 */
class BrandCartridgesService
{
    public static function save(PrinterNames $brand, Request $request)
    {
        $currentBrandCartridges = CartridgesOfPrinter::select('id_tovari as id')
                                    ->where('id_orgtekhnika', $brand->id)
                                    ->get();
        $currentBrandCartridges = self::idCartridge($currentBrandCartridges->toArray());
        $idRequestCartriges = self::idCartridge($request->only('cartridges'));
        $removalCartridge = self::forRemoving(collect($currentBrandCartridges), $idRequestCartriges);
        $remainingCurrentCartridges =  self::withOutRemoval(collect($currentBrandCartridges), $removalCartridge);
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
        }, $cartridges);

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
}
