<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PrinterResource;
use App\Model\PrinterNames;
use App\Model\Printers;
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
        $collection = collect([1, 2, 3]);

        $intersect = $collection->intersect([]);
        
        $intersect->all();
        dd(array_unique($idCartridges));
    }
}
