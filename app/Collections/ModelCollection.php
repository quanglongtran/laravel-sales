<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

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
