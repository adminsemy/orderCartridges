<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderMethodRequest;
use App\Http\Resources\Admin\OrderResource;
use App\Model\HistoryOrder;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $order)
    {
        $this->orderService = $order;                        
    }
    
    public function index()
    {
        $orders = HistoryOrder::query()->where('action', 0)->get();
        return OrderResource::collection($orders);
    }

    public function create($id, Request $request)
    {
        $cartridges = $this->orderService->checkCartridges($id, $request->all());
        if (empty($cartridges)) {
            return response()->json(['message' => 'Not order']);
        }
        try {
            HistoryOrder::insert($this->orderService->structue($id, $cartridges));
            return response()->json(['message' => 'Order completed']);
        } catch (DomainException $e ) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    public function sendCartridge(HistoryOrder $historyOrder, OrderMethodRequest $request)
    {
        try {
            $sendOrder = $this->orderService->orderCartridge($historyOrder, $request->cartridge);
            return response()->json(['message' => $sendOrder->getMessage()]);
        } catch (DomainException $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }
}
