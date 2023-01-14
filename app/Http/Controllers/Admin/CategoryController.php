<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategory;
use App\Http\Requests\Category\UpdateCategory;
use App\Models\Category;
use App\Traits\PermissionMiddleware;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use PermissionMiddleware;
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->setMidleware('category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->latest('id')->paginate(15);
        return \view('admin.category.index', \compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = $this->category->getParents();

        return \view('admin.category.create', \compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategory $request)
    {
        $this->category->create($request->all());
        return \to_route('category.index');
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
        $category = $this->category->with('children')->with('parent')->find($id);
        // dd($category->parent);
        $parentCategories = $this->category->getParents();

        return \view('admin.category.edit', \compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, $id)
    {
        $this->category->findOrFail($id)->update($request->all());
        return \to_route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->children()->delete();
        $this->category->destroy($id);

        \notify('Delete category successfully', null, 'success');
        return \to_route('category.index');
    }
}
