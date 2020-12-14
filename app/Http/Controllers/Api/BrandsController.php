<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BrandsResource;
use App\Http\Resources\Admin\PrinterNameResource;
use App\Http\Resources\BrandNameResource;
use App\Model\PrinterNames;
use App\Services\BrandCartridgesService;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandsController extends Controller
{
    /**
     * Return collection name printers
     *
     * @return AnonymousResourceCollection
     */
    public function brands(): AnonymousResourceCollection
    {
        return PrinterNameResource::collection(PrinterNames::all());
    }
    
    /**
     * Return collection printers with keys - id, name
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $brands = PrinterNames::with(['cartridgesOfPrinter' => function ($query) {
            $query->with('cartridge');
        }])->get();
        return BrandsResource::collection($brands);
    }

    public function store(Request $request)
    {
        $newBrand = PrinterNames::create(['name' => $request->name]);
        if ($newBrand) {
            return response()->json(['message' => 'Brand added']);
        } else {
            return response()->json(['message' => 'Brand is not added']);
        }
    }

    public function update(PrinterNames $brand, Request $request)
    {
        if (BrandCartridgesService::save($request)) {
            return response()->json(['message' => 'Brand updated']);
        } else {
            return response()->json(['message' => 'Brand is not updated']);
        }
    }
    
    /**
     * Delete brand
     *
     * @param  PrinterNames $brand
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(PrinterNames $brand)
    {
        try {
            $brand->delete();
            return response('', 204);
        } catch (DomainException $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Returns collection brands with columns
     * 'id'  and 'name' sorted by ask
     *
     * @return JsonResource
     */
    public function brandsName(): JsonResource
    {
        $sortBrandsName = PrinterNames::all()->sortBy('name');
        return BrandNameResource::collection($sortBrandsName);
    }
}
