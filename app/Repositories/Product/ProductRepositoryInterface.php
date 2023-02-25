<?php

namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function storeProduct(Request $request);

    public function updateProduct(Request $request, int $id);

    public function syncDetails(array $parameter);

    /**
     * Get the product by category id
     *
     * @param  mixed $categoryId
     * @return void
     */
    public function getByCategory(int $categoryId);
}
