<?php

namespace App\Services;

use App\Model\PrinterNames;
use App\Model\Printers;
use DomainException;

class PrinterService
{    
        
    /**
     * Add new printer in the database
     *
     * @param  mixed $request
     * @return bool
     */
    public function newPrinter($request): bool
    {
        $brand = PrinterNames::where('name', $request->name)->first();
        if (empty($brand)) {
            return false;
        } else {
            try {
                $newPrinter = new Printers();
                $newPrinter->id_name = $brand->id;
                $newPrinter->serial = $request->serialNumber;
                $newPrinter->inventory_number = $request->inventoryNumber;
                $newPrinter->users = $request->uin;
                $newPrinter->save();
                return true;
            } catch (DomainException $e) {
                return false;
            }
        }
    }

    /**
     * Add new printer in the database
     *
     * @param  mixed $request
     * @return bool
     */
    public function editPrinter(Printers $printer, $request): bool
    {
        $brand = PrinterNames::where('name', $request->name)->first();
        if (empty($brand)) {
            return false;
        } else {
            try {
                $printer->serial = $request->serialNumber;
                $printer->inventory_number = $request->inventoryNumber;
                $printer->users = $request->uin;
                $printer->save();
                return true;
            } catch (DomainException $e) {
                return false;
            }
        }
    }
}