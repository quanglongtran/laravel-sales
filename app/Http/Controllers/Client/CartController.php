<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartProduct\CreateCartProduct;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Repositories\Client\Cart\CartRepositoryInterface;
use App\Repositories\Client\CartProduct\CartProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cart;
    protected $cartProduct;

    public function __construct(CartRepositoryInterface $cart, CartProductRepositoryInterface $cartProduct)
    {
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;

        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->cart->firstOrCreate()->getRelationships();

        return \view('client.cart.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCartProduct $request)
    {
        $this->cartProduct->addToCart($request);

        \notify('Product has been added to your cart', null, 'success');
        return \to_route('cart.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkout()
    {
        $cart = $this->cart->checkout();

        return view('client.cart.checkout', compact('cart'));
    }

    public function checkoutHandle(CreateOrderRequest $request)
    {
        $this->cart->checkoutHandle($request);

        \notify('Order Success', null, 'success');
        return \to_route('product.index');
    }
}
