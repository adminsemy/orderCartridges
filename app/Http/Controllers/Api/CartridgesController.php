<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CartridgeResource;
use App\Http\Resources\CartrigeNameResource;
use App\Model\Cartridge;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartridgesController extends Controller
{    
    /**
     * Return all cartridges in collection
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $cartrides = Cartridge::with(['brandsOfCartridge' => function ($query) {
            $query->with('printer');
        }])->get();
        return CartridgeResource::collection($cartrides);
    }

    /**
     * Returns collection cartridges with columns
     * 'id'  and 'name' sorted by ask
     *
     * @return JsonResource
     */
    public function cartridgeName(): JsonResource
    {
        $sortCartridgeNames = Cartridge::all()->sortBy('marka');
        return CartrigeNameResource::collection($sortCartridgeNames);
    }
}
