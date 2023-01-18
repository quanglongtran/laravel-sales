<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Admin\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public $order;

    public function __construct(OrderRepositoryInterface $order)
    {
        $this->order = $order;
        $this->middleware(['permission:show-order'], ['only' => 'index']);
        $this->middleware(['permission:update-order'], ['only' => 'updateStatus']);
    }

    public function index()
    {
        $orders = $this->order->getWithPaginateBy(\auth()->user()->getAuthIdentifier());

        return \view('admin.order.index', \compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        $order = $this->order->update($request->order_id, ['status' => $request->status]);

        if ($order) {
            return \jsonResponse(true, 'Successful status change', ['order' => $order]);
        }

        return \jsonResponse(false, 'Order not found!');
    }
}
