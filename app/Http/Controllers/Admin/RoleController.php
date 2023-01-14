<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
// use App\Models\Permission;
// use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest('id')->paginate(5);

        // return $roles;
        return \view('admin.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group');

        return \view('admin.roles.create', \compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $dataCreate = $request->all();
        $role = Role::create($dataCreate);
        $role->permissions()->attach($dataCreate['permission_ids']);
        \notify("Create $role->display_name role successfully", '', 'success');

        return \to_route('role.index')->with(['message' => 'Create success']);
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
        $role = Role::with('permissions')->findOrFail($id);

        if ($role->name == 'super-admin') {
            \notify('Sorry, you cannot edit Super Admin role!', null, 'error');
            return \back();
        }

        $permissions = Permission::all()->groupBy('group');

        return \view('admin.role.edit', \compact('role', 'permissions'));
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
        $role = Role::findOrFail($id);
        $dataUpdate = $request->all();

        $role->permissions()->sync($dataUpdate['permission_ids']);

        Artisan::call('cache:clear');
        \notify("Edit $role->display_name role successfully", null, 'success');
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
        Role::destroy($id);

        \notify('Delete role successfully', \null, 'success');
        return \to_route('role.index');
    }
}
