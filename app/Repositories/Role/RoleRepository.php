<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepository;
use App\Repositories\Permission\PermissionRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    public function getModel()
    {
        return \Spatie\Permission\Models\Role::class;
    }

    public function syncPermissions($id, $permission_ids)
    {
        $this->model->findOrFail($id)->permissions()->sync($permission_ids);
        return $this->model;
    }

    public function storeRole($attributes = [], $permission_ids = [])
    {
        return $this->syncPermissions($this->model->create($attributes)->id, $permission_ids);
    }

    public function edit($id)
    {
        $role = $this->findOrFail($id);

        if ($role->name == 'super-admin') {
            // \notify('Sorry, you cannot edit Super Admin role!', null, 'error');
            \abort(404, 'Not found');
            return false;
        }

        $permissions = (new PermissionRepository)->getAll()->groupBy('group');

        return \compact('role', 'permissions');
    }
}
