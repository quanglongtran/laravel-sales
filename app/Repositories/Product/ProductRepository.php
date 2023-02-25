<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function storeProduct($request)
    {
        $product = $this->create(array_merge($request->all(), [
            'request' => $request,
        ]));

        $product->assignCategory($request->category_ids);

        $this->syncDetails(json_decode($request->input('details')));
    }

    public function updateProduct($request, $id)
    {
        $product = $this->update($id, array_merge($request->all(), [
            'request' => $request,
        ]));

        $product->assignCategory($request->category_ids);

        $this->syncDetails(json_decode($request->input('details')));
    }

    public function syncDetails(array $parameter)
    {
        $details = [];
        foreach ($parameter as $key => $value) {
            if (!$value->size || !$value->quantity) continue;
            $details[$key] = (array) $value;
            $details[$key]['product_id'] = $this->model->id;
            $details[$key]['created_at'] = now()->format('Y-m-d H:i:s');
            $details[$key]['updated_at'] = now()->format('Y-m-d H:i:s');
        }

        $this->model->details()->delete();
        $this->model->details()->insert($details);
        return $details;
    }

    public function getByCategory($categoryId)
    {
        return $this->relationships(['images'])->whereHas('categories', fn ($q) => $q->where('category_id', $categoryId))->paginate(12);
    }
}
