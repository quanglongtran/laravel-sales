<?php

namespace App\Collections;

use App\Collections\ModelCollection;

class CategoryCollection extends ModelCollection
{
    public function withProducts($category_id, $paginate = 15)
    {
        return $this->toQuery()->whereHas('products', fn ($q) => $q->where('category_id', $category_id))->paginate($paginate);
    }
}
