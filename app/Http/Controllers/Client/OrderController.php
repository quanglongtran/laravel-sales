<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $order;

    public function __construct(OrderRepositoryInterface $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = $this->order->getByUserId(\auth()->user()->getAuthIdentifier());

        return \view('client.order.index', \compact('orders'));
    }

    public function delete($id)
    {
        if ($this->order->cancel($id)) {
            return jsonResponse(true, 'Order has been canceled successfully');
        }

        return jsonResponse(false, 'Order not found');
    }
}
