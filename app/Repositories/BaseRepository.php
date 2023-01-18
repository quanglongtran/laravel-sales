<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Traits\HandleImageUpLoad;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseRepository implements RepositoryInterface
{
    use HandleImageUpLoad;

    /**
     * Current model
     *
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * Name of the model
     *
     * @var string
     */
    protected $modelName;

    public function __construct()
    {
        $this->setModel();
    }

    public function getLatest(string $column = 'id', array $relationships = [])
    {
        $result = $this->relationships($relationships)->latest($column)->paginate(12);

        $this->getImage($relationships, $result->items());

        return $result;
    }

    /**
     * Get model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function getModel();

    /**
     * Set model
     * 
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );

        $this->modelName = strtolower(class_basename($this->model));
        return $this->model;
    }

    public function getAll(array $columns = ['*'], $relationships = [])
    {
        $result = $this->relationships($relationships)->all($columns);

        $this->getImage($relationships, $result);
        return $result;
    }

    public function find($id, $relationships = [], $columns = ['*'])
    {
        $result = $this->relationships($relationships)->find($id);

        $this->model = $result;
        $this->getImage($relationships);

        return $result;
    }

    public function findOrFail($id, $relationships = [], $columns = ['*'])
    {
        $result = $this->relationships($relationships)->findOrFail($id);

        $this->model = $result;
        $this->getImage($relationships);

        return $result;
    }

    public function findMany($ids, $columns = ['*'])
    {
        $ids = $ids instanceof Arrayable ? $ids->toArray() : $ids;

        if (empty($ids)) {
            return $this->model->newCollection();
        }

        return $this->model->whereKey($ids)->get($columns);
    }

    public function create($attributes = [])
    {
        $relationships = isset($attributes['relationships']) ? $attributes['relationships'] : [];
        $result = $this->relationships($relationships)->create($attributes);
        $this->model = $result;

        if (isset($attributes['request'])) {
            $this->storeImage($attributes['request']);
        }
        $this->getImage($relationships);
        return $result;
    }

    public function update($id, $attributes = [])
    {
        $relationships = isset($attributes['relationships']) ? $attributes['relationships'] : [];
        $result = $this->find($id, $relationships);

        if (!$result) {
            return false;
        }

        $result->update($attributes);
        $this->model = $result;

        if (isset($attributes['request'])) {
            $this->updateImage($attributes['request']);
        }
        $this->getImage($relationships);

        return $result;
    }

    public function delete($id, array $relationships = [])
    {
        $result = $this->find($id);
        if ($result) {
            if (!empty($relationships)) {
                foreach ($relationships as $relationship) {
                    $result->$relationship()->delete();
                }
            }

            $result->delete();
            $this->deleteImage();
            return true;
        }

        return false;
    }

    public function relationships(array $relationships)
    {
        if (!empty($relationships)) {
            if (isset($relationships['relationships'])) {
                $relationships = $relationships['relationships'];
            }
            return $this->model->with($relationships);
        }

        return $this->model;
    }

    public function getImage(array $relationships = [], $modelCollection = null)
    {
        if (\collect($relationships)->contains('images')) {
            if ($modelCollection) {
                foreach ($modelCollection as $item) {
                    $item->image_path = \getImage($item, $this->modelName);
                }
            } else {
                $this->model->image_path = \getImage($this->model, $this->modelName);
            }
        }
        return false;
    }
}
