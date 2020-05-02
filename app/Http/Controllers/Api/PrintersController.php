<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrinterResource;
use App\Model\Printers;
use Illuminate\Http\Request;

class PrintersController extends Controller
{
    public function index()
    {
        $printer = Printers::query()->with('printerName')->get();
        return PrinterResource::collection($printer);
    }
}
