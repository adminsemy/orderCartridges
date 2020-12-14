<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CartridgeResource;
use App\Http\Resources\CartrigeNameResource;
use App\Model\Cartridge;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\BrandCartridgesService;
use Exception;

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
     * Save a new cartridge in the data base
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $newCartridge = Cartridge::create(['marka' => $request->name]);
        if ($newCartridge) {
            return response()->json(['message' => 'Cartridge added']);
        } else {
            return response()->json(['message' => 'Cartridge is not added']);
        }
    }

    public function update(Cartridge $cartridge, Request $request)
    {
        $service = new BrandCartridgesService($cartridge, 'brandsOfCartridge', 'id_orgtekhnika');
        try {
            $service->handle($request->brands, 'id_tovari');
            return response()->json(['message' => 'Brand updated']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

     /**
     * Delete cartridge
     *
     * @param  PrinterNames $brand
     * @return ResponseFactory|Response
     */
    public function delete(Cartridge $cartridge)
    {
        try {
            $cartridge->delete();
            return response('', 204);
        } catch (\DomainException $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Returns collection cartridges with columns
     * 'id'  and 'name' sorted by ask
     *
     * @return JsonResource
     */
    public function cartridgesName(): JsonResource
    {
        $sortCartridgesName = Cartridge::all()->sortBy('marka');
        return CartrigeNameResource::collection($sortCartridgesName);
    }
}
