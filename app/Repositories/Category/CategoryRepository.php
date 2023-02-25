<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getParents()
    {
        return $this->model->whereNull('parent_id')->get(['id', 'name'])->loadMissing('parent');
    }

    public function children()
    {
        return $this->model->hasMany(Category::class, 'parent_id');
    }

    public function edit($id)
    {
        return [
            'category' => $this->findOrFail($id, ['children', 'parent']),
            'parentCategories' => $this->getParents()
        ];
    }
}
