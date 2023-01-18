<?php

namespace App\Repositories\Admin\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getParents();

    public function children();

    public function edit(int $id);
}
