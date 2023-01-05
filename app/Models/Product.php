<?php

namespace App\Models;

use App\Collections\ProductCollection;
use App\Traits\HandleImageUpLoad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HandleImageUpLoad;

    protected $fillable = [
        'name',
        'description',
        'sale',
        'price'
    ];

    /**
     * Custom collection
     *
     * @param  mixed $models
     * @return void
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function assignCategory($categoryIds)
    {
        return $this->categories()->sync($categoryIds);
    }

    public function getBy($dataSearch, $categoryId)
    {
        return $this->with('images')->whereHas('categories', fn ($q) => $q->where('category_id', $categoryId))->paginate();
    }
}
