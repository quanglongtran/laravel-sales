<?php

namespace App\Repositories\Admin\User;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function storeUser($request)
    {
        $password = bcrypt($request->password);
        $user = $this->create(\array_merge($request->all(), [
            'password' => $password,
            'request' => $request
        ]));
        $user->assignRole($request->role_ids);
    }

    public function updateUser($request, $id)
    {
        $password = $request->has('password') ? \bcrypt($request->password) : $this->model->password;

        $this->update($id, array_merge($request->all(), [
            'password' => $password,
            'request' => $request,
        ]));

        $this->model->syncRoles($request->role_ids);
    }
}
