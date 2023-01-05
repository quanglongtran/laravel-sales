<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Traits\HandleImageUpLoad;

/**
 * ModelCollection
 */
class ModelCollection extends Collection
{
    public function withImage()
    {
        return $this->loadMissing('images')->map((function ($model) {
            $model->image = \getImage($model);
            return $model;
        }));
    }
}
