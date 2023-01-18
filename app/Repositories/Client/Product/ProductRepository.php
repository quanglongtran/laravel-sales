<?php

namespace App\Repositories\Client\Product;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function getByCategory($categoryId)
    {
        return $this->relationships(['images'])->whereHas('categories', fn ($q) => $q->where('category_id', $categoryId))->paginate(12);
    }
}
