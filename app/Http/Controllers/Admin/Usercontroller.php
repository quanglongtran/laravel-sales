<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    protected User $user;
    protected Role $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->latest('id')->paginate(15);

        return \view('admin.user.index', \compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->all()->groupBy('group');

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
        $user = $this->user->create(\array_merge($request->all(), ['password' => \bcrypt($request->password)]));
        $path_avatar = $this->user->storeImage($request, 'users');
        $user->images()->create(['url' => $path_avatar]);
        $user->assignRole($request->role_ids);

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
        $user = $this->user->findOrFail($id)->load('roles');
        // return ($user);
        $roles = $this->role->all()->groupBy('group');

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
        $user = $this->user->findOrFail($id)->load('roles');
        $password = $request->password ? \bcrypt($request->password) : $user->password;

        if (!is_null($request->avatar) && $request->hasFile('avatar')) {
            // $user->images()->delete();
            $user->updateImage($request);
        }

        $user->update(\array_merge($request->all(), \compact('password')));
        $user->syncRoles($request->role_ids);

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
        $user = $this->user->findOrFail($id);
        $user->deleteImage($user->images->count() > 0 ? $user->images->url : '')->delete();
        \notify('Delete user successfully', \null, 'success');
        return to_route('admin.user.index');
    }
}
