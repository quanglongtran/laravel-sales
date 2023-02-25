<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategory;
use App\Http\Requests\Category\UpdateCategory;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Traits\PermissionMiddleware;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use PermissionMiddleware;
    private $category;

    public function __construct(CategoryRepositoryInterface $category)
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
        $categories = $this->category->getLatest('id');

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
        \successNotify('Create a successful category');
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
        return \view('admin.category.edit', $this->category->edit($id));
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
        $this->category->update($id, $request->all());
        \successNotify('Category update successful');
        return \to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->delete($id, ['children']);

        \successNotify('Delete category successfully');
        return \to_route('admin.category.index');
    }
}
