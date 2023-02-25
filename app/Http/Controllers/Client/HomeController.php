<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $product
     * @return void
     */
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = $this->product->getLatest('id');

        return view('client.home.index', \compact('products'));
    }
}
