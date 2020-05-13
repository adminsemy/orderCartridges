<?php

namespace App\Services;

use App\Model\CartridgesOfPrinter;
use App\Model\HistoryOrder;
use App\Model\Printers;

class OrderService
{
    /* 
     * Checks for matching cartridge id printer
     */
    public function checkCartridges(int $id_printer, array $order_cartridges): array
    {
        $printer = Printers::find($id_printer);
        $cartridges = CartridgesOfPrinter::query()->where('id_orgtekhnika', $printer->id_name)->pluck('id_tovari');
        $collectionCartridges = collect($cartridges);
        $intersect = $collectionCartridges->intersect($order_cartridges);
        $historyOrder = HistoryOrder::query()->where([
            'id_tehniki' => $id_printer,
            'action' => '0'
        ])->pluck('id_cartridge');
        $collectionHistoryOrder = collect($intersect->all());
        $result = $collectionHistoryOrder->diff($historyOrder);
        return $result->all();
    }

    /* 
     * Strutrure array cartridges after to saving in database
     */
    public function structue(int $id_printer, array $cartridges): array
    {
        $structure = [];
        foreach ($cartridges as $cartridge) {
            $structure[] = [
                'id_tehniki' => $id_printer,
                'id_cartridge' => $cartridge,
                'action' => 0,
                'data' => date('Y-m-d H:i:s')
            ];
        }

        return $structure;
    }
}