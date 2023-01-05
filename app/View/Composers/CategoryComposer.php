<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Repositories\UserRepository;
use Illuminate\View\View;

class CategoryComposer
{
    protected Category $category;


    /**
     * __construct
     *
     * @param  Category $category
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->category->getParents());
    }
}
