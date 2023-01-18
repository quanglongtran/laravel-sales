<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Repositories\Admin\Role\RoleRepositoryInterface;
use App\Repositories\Admin\User\UserRepositoryInterface;
use App\Traits\PermissionMiddleware;

class Usercontroller extends Controller
{
    use PermissionMiddleware;
    protected $user;
    protected $role;

    public function __construct(UserRepositoryInterface $user, RoleRepositoryInterface $role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->setMidleware('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->getLatest('id', ['images']);

        return \view('admin.user.index', \compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = $this->role->all()->groupBy('group');
        $roles = $this->role->getAll()->groupBy('group');

        return \view('admin.user.create', \compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $this->user->storeUser($request);

        return \to_route('admin.user.index');
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
        $user = $this->user->findOrFail($id, ['roles', 'images']);

        $roles = $this->role->getAll()->groupBy('group');

        return \view('admin.user.edit', \compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // return $request->all();
        $this->user->updateUser($request, $id);

        return \to_route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->delete($id);
        \notify('Delete user successfully', \null, 'success');
        return to_route('admin.user.index');
    }
}
