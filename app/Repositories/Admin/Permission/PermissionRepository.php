<?php

namespace App\Repositories\Admin\Permission;

use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function getModel()
    {
        return \Spatie\Permission\Models\Permission::class;
    }
}
