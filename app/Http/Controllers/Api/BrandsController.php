<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BrandsResource;
use App\Http\Resources\Admin\PrinterNameResource;
use App\Model\PrinterNames;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function brands()
    {
        return PrinterNameResource::collection(PrinterNames::all());
    }

    public function index()
    {
        $brands = PrinterNames::all();
        return BrandsResource::collection($brands);
    }
}
