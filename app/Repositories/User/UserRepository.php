<?php

namespace App\Repositories\User;

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
        $password = $request->password ? ['password' => bcrypt($request->password)] : [];

        if (!$request->password) {
            $request->request->remove('password');
        }
        
        $user = $this->update($id, array_merge($request->all(), [
            'request' => $request,
            ...$password,
        ]));

        if ($request->has('role_ids')) {
            $this->model->syncRoles($request->role_ids);
        }

        return $user;
    }
}
