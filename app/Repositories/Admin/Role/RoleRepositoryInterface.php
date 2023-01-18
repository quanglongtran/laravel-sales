<?php

namespace App\Repositories\Admin\Role;

use App\Repositories\RepositoryInterface;

interface RoleRepositoryInterface extends RepositoryInterface
{
    public function syncPermissions(int $id, array $permission_ids);

    public function storeRole(array $attributes = [], array $permission_ids = []);

    public function edit(int $id);
}
