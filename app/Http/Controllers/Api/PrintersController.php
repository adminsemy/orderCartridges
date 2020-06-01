<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PrinterNameResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PrinterResource;
use App\Model\Cartridge;
use App\Model\HistoryOrder;
use App\Model\PrinterNames;
use App\Model\Printers;
use App\Services\OrderService;
use App\Services\PrinterService;
use DomainException;
use Illuminate\Http\Request;

class PrintersController extends Controller
{
    private $printerService;

    public function __construct(PrinterService $printerService)
    {
        $this->printerService = $printerService;
    }

    public function index()
    {
        $printer = Printers::query()->with('printerName')->get();
        return PrinterResource::collection($printer);
    }

    public function show(Printers $printer)
    {
        return new OrderResource($printer);
    }

    public function brands()
    {
        return PrinterNameResource::collection(PrinterNames::all());
    }
    
    public function store(Request $request)
    {
        $newPrinter = $this->printerService->newPrinter($request);
        if ($newPrinter) {
            return response()->json(['message' => 'Printer added']);
        } else {
            return response()->json(['message' => 'Printer is not added']);
        }
    }
    
    public function update(Printers $printer, Request $request)
    {
        $currentPrinter = $this->printerService->editPrinter($printer, $request);
        if ($currentPrinter) {
            return response()->json(['message' => 'Printer edited']);
        } else {
            return response()->json(['message' => 'Printer is not edited']);
        }
    }
    public function delete(Printers $printer)
    {
        try {
            $printer->delete();
            return response('', 204);
        } catch (DomainException $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    public function test()
    {
        $printer = PrinterNames::where('name', 'HP DESIGNJET 500 plus (плотер)')->first();
        if (empty($printer)) {
            dd(false);
        } else {
            dd($printer->id);
        }
    }
}
