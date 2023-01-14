<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use App\Traits\PermissionMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use PermissionMiddleware;

    public Product $product;
    public Category $category;

    public function __construct(Product $product, Category $category)
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
        $products = $this->product->latest('id')->paginate(15);

        return \view('admin.product.index', \compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->all(['id', 'name']);

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
        $product = $this->product->create($request->all());
        $product->storeImage($request, 'products');
        $product->assignCategory($request->category_ids);

        $details = [];
        foreach (collect(json_decode($request->input('details')))->toArray() as $key => $value) {
            $details[$key] = (array) $value;
            $details[$key]['product_id'] = $product->id;
            $details[$key]['created_at'] = now()->format('Y-m-d H:i:s');
            $details[$key]['updated_at'] = now()->format('Y-m-d H:i:s');
        }
        DB::table('product_details')->insert($details);

        return \to_route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        // dd($product->categories->get('name'));

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
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        $categories = $this->category->all(['id', 'name']);
        // return ($product);

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
        $product = $this->product->findOrFail($id);
        $product->updateImage($request, 'products');
        $product->update($request->all());

        $product->assignCategory($request->category_ids);

        $details = [];
        foreach (json_decode($request->input('details')) as $key => $value) {
            $details[$key] = (array) $value;
            $details[$key]['product_id'] = $product->id;
            $details[$key]['created_at'] = now()->format('Y-m-d H:i:s');
            $details[$key]['updated_at'] = now()->format('Y-m-d H:i:s');
        }

        $product->details()->delete();
        $product->details()->insert($details);

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
        $product = $this->product->findOrFail($id);

        $product->details()->delete();
        $product->deleteImage();
        $product->delete();
        \notify('Delete product successfully', null, 'success');

        return \to_route('product.index');
    }
}
