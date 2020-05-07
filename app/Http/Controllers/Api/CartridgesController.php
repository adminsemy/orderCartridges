<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\Printer;

class CartridgesController extends Controller
{
    public function showCartridgesOfPrinter(Printer $printer)
    {
        $idPrinterName = $printer->printerName->id;

    }
}
