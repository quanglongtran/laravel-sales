<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartProduct\CreateCartProduct;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $order;

    public function __construct(Cart $cart, Product $product, CartProduct $cartProduct, Coupon $coupon, Order $order)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->order = $order;

        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::enableQueryLog();
        $cart = $this->cart->firstOrCreate(['user_id' => auth()->user()->getAuthIdentifier()]);
        $cartProducts = $cart->cartProducts();
        $products = $cartProducts->get();

        $response = [
            'cart' => $cart,
            'cartProducts' => $cartProducts->paginate(),
            'products' => $products,
        ];

        return \view('client.cart.index', $response);
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
        $product = $this->product->findOrFail($request->product_id);
        $cart = $this->cart->firstOrCreate(['user_id' => auth()->user()->getAuthIdentifier()]);
        $cartProduct = $this->cartProduct->getBy($cart->id, $product->id, $request->size);

        if ($cartProduct) {
            $cartProduct->product_quantity += $request->quantity;
        } else {
            $cartProduct = $this->cartProduct;
            $cartProduct->cart_id = $cart->id;
            $cartProduct->product_size = $request->size;
            $cartProduct->product_quantity = $request->quantity;
            $cartProduct->product_price = $product->price;
            $cartProduct->product_id = $product->id;
        }

        $cartProduct->save();

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

    public function updateQuantity(Request $request, $id)
    {
        if (!$request->has('product_quantity')) {
            return \notify('Product quantity is required!', 'Error', 'error');
        }

        $cartProduct = $this->cartProduct->find($id);

        if ($request->product_quantity < 1) {
            $cartProduct->delete();
            $message = 'Product has been removed from your cart!';
        } else {
            $cartProduct->update($request->all());
            $message = 'Product quantity has been updated!';
        }

        $response = [
            'quantity' => $request->product_quantity,
            // 'cart' => new CartResource($cartProduct->cart),
        ];

        if ($request->ajax()) {
            return \jsonResponse(true, $message, $response);
        } else {
            $notify = notify('Update cart successfully', null, 'success');
            return \back()->with('withNotify', $notify);
        }
    }

    public function applyCoupon(Request $request)
    {
        $name = $request->input('coupon_code');
        $coupon = $this->coupon->firstWithExpired($name, auth()->user()->getAuthIdentifier());
        $couponSessions = \collect(['coupon_id' => optional($coupon)->id, 'discount_amount_price' => optional($coupon)->value, 'coupon_code' => $name]);

        if ($coupon) {
            $couponSessions->each(fn ($value, $key) => session([$key => $value]));
            return jsonResponse(true, 'Coupon successfully applied coupon code', [
                'coupon_code' => $name,
                'discount_amount_price' => $coupon->value,
                'coupon_id' => $coupon->id
            ]);
        } else {
            session()->forget(\json_decode($couponSessions->keys()));
            return jsonResponse(false, 'Coupon code applied failed');
        }
    }

    public function checkout()
    {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('cartProducts');

        return view('client.cart.checkout', compact('cart'));
    }

    public function checkoutHandle(CreateOrderRequest $request)
    {
        $this->order->create(\array_merge($request->all(), [
            'user_id' => \auth()->user()->getAuthIdentifier(),
            'status' => 'pending'
        ]));

        if ($couponId = \session()->get('coupon_id')) {
            if ($coupon = $this->coupon->find($couponId)) {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
                // return $coupon;
            }
        }

        $cart = $this->cart->firstOrCreateBy(auth()->user()->getAuthIdentifier());
        $cart->cartProducts->each->delete();

        session()->forget(['coupon_code', 'discount_amount_price', 'coupon_id']);
    }
}
