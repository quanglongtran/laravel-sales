<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;

class RoleController extends Controller
{
    private $role;
    private $permission;

    public function __construct(RoleRepositoryInterface $role, PermissionRepositoryInterface $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('admin.role.index', ['roles' => $this->role->getLatest('id')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permission->getAll()->groupBy('group');

        return \view('admin.role.create', \compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $role = $this->role->storeRole($request->all(), $request->permission_ids);

        \successNotify("Create $role->display_name role successfully");
        return \to_route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$result = $this->role->edit($id)) {
            return \back();
        }

        return \view('admin.role.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->role->update($id, $request->all())->syncPermissions($request->permission_ids);

        \successNotify("Edit $role->display_name role successfully");
        return \to_route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->role->delete($id);

        \successNotify('Delete role successfully');
        return \to_route('admin.role.index');
    }
}
