<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    /**
     * getLatest
     *
     * @param  string $column
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function getLatest(string $column = 'id', array $relationships = []);

    /**
     * Get all
     * @return mixed
     */
    public function getAll(array $columns = ['*'], array $relationships = []);

    /**
     * find
     *
     * @param  int $id
     * @param  array $relationships
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Builder|null
     */
    public function find(int $id, array $relationships = [], $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $relationships
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[]
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function findOrFail(int $id, array $relationships = [], $columns = ['*']);

    /**
     * Find multiple models by their primary keys.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $ids
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany(array $ids, array $columns = ['*']);

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes = []);

    /**
     * Update
     * @param int $id
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|false
     */
    public function update(int $id, array $attributes = []);

    /**
     * Delete
     * @param int $id
     * @return bool
     */
    public function delete($id, array $relationships = []);
}
