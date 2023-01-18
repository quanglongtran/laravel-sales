<?php

namespace App\Repositories\Admin\Product;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function storeProduct(Request $request);

    public function updateProduct(Request $request, int $id);

    public function syncDetails(array $parameter);
}
