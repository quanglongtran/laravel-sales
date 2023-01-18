<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Repositories\Admin\Product\ProductRepositoryInterface;
use App\Traits\PermissionMiddleware;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use PermissionMiddleware;

    public $product;
    public $category;

    public function __construct(ProductRepositoryInterface $product, CategoryRepositoryInterface $category)
    {
        $this->category = $category;
        $this->product = $product;
        $this->setMidleware('product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->getLatest();

        return \view('admin.product.index', \compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->getAll(['id', 'name']);

        return \view('admin.product.create', \compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        // return $request->all();
        $this->product->storeProduct($request);

        return \to_route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->findOrFail($id, ['details', 'categories']);

        return \view('admin.product.show', \compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->findOrFail($id, ['details', 'categories']);
        $categories = $this->category->getAll(['id', 'name']);

        return \view('admin.product.edit', \compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Product\UpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $this->product->updateProduct($request, $id);

        return \to_route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product->delete($id, ['details']);
        \notify('Delete product successfully', null, 'success');

        return \to_route('admin.product.index');
    }
}
