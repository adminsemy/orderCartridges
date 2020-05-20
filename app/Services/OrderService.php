<?php

namespace App\Services;

use App\Model\Cartridge;
use App\Model\CartridgesOfPrinter;
use App\Model\HistoryOrder;
use App\Model\Printers;
use phpDocumentor\Reflection\Types\Boolean;

class OrderService
{
    private $statusOrder;
    private $message = '';
    /**
     * Checks for matching cartridge id printer
     *
     * @param  mixed $id_printer
     * @param  mixed $order_cartridges
     * @return array
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

        
    /**
     * Strutrure array cartridges after to saving in database
     *
     * @param  int $id_printer
     * @param  array $cartridges
     * @return array
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
        
    /**
     * Check for a cartridge and place an order
     *
     * @param  HistoryOrder $historyOrder
     * @return self
     */
    public function orderCartridge(HistoryOrder $historyOrder, $cartridge): self
    {
        if ($cartridge === HistoryOrder::NEW_CARTRIDGE) {
            $this->orderNewCartridge($historyOrder);
        } elseif ($cartridge === HistoryOrder::SEASONED_CARTRIDGE) {
            $this->orderSeasonedCartridge($historyOrder);
        } else {
            $this->statusOrder = false;
            $this->message = 'Cannot send cartridge';
        }
        return $this;
    }

    public function getStatusOrder()
    {
        return $this->statusOrder;
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function orderNewCartridge(HistoryOrder $historyOrder): void
    {
        $cartridge = Cartridge::find((int)$historyOrder->id_cartridge);
        if ($cartridge->isNewCartridge()) {
            $historyOrder->zakaz = HistoryOrder::GIVE_NEW;
            $historyOrder->action = HistoryOrder::ORDER_COMPLITED;
            $historyOrder->save();
            $cartridge->all = $cartridge->all - 1;
            $cartridge->save();
            $this->statusOrder = true;
            $this->message = 'New cartridge was sended';
        } else {
            $this->statusOrder = false;
            $this->message = 'Not a new cartidge';
        }
    }

    private function orderSeasonedCartridge(HistoryOrder $historyOrder): void
    {
        $historyOrder->zakaz = HistoryOrder::GIVE_SEASONED;
        $historyOrder->action = HistoryOrder::ORDER_COMPLITED;
        $historyOrder->save();
        $this->statusOrder = true;
        $this->message = 'Seasoned cartridge was sended';        
    }
}