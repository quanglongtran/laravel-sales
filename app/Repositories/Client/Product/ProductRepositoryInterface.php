<?php

namespace App\Repositories\Client\Product;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * Get the product by category id
     *
     * @param  mixed $categoryId
     * @return void
     */
    public function getByCategory(int $categoryId);
}
