<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BrandsResource;
use App\Http\Resources\Admin\PrinterNameResource;
use App\Model\PrinterNames;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        $brands = PrinterNames::all();
        return BrandsResource::collection($brands);
    }
}
