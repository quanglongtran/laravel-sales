<?php

namespace App\Models;

use App\Collections\CategoryCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    /**
     * Custom collection
     *
     * @param  array $models
     * @return CategoryCollection
     */
    public function newCollection(array $models = [])
    {
        return new CategoryCollection($models);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getParentNameAttribute()
    {
        return optional($this->parent)->name;
    }

    public function getParents()
    {
        return Category::with('childrens')->whereNull('parent_id')->get(['id', 'name']);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
