<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PrinterResource;
use App\Model\Cartridge;
use App\Model\HistoryOrder;
use App\Model\Printers;
use App\Services\OrderService;

class PrintersController extends Controller
{
    public function index()
    {
        $printer = Printers::query()->with('printerName')->get();
        return PrinterResource::collection($printer);
    }

    public function show(Printers $printer)
    {
        return new OrderResource($printer);
    }

    public function test()
    {
        $cart = HistoryOrder::find(1744);
        $orderservice = new OrderService;
        dd($orderservice->orderNewCartridge($cart));
    }
}
