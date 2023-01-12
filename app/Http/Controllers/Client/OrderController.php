<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = $this->order->getWithPaginateBy(\auth()->user()->getAuthIdentifier());

        return \view('client.order.index', \compact('orders'));
    }

    public function delete($id)
    {
        if ($order = $this->order->find($id)) {
            $order->update(['status' => 'canceled']);
            return \jsonResponse(true, 'Order has been canceled successfully', ['order' => $order]);
        }

        return \jsonResponse(false, 'Order not found');
    }
}
