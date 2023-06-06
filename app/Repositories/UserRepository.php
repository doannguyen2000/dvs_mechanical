<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    public function getAll($params)
    {
        $users = User::where(function ($query) use ($params) {
            if (!empty($params['search']))
                $query->where('full_name', 'like', '%' . $params['search'] . '%')
                    ->orWhere('name', 'like', '%' . $params['search'] . '%')
                    ->orWhere('email', 'like', '%' . $params['search'] . '%');
        });
        if (!empty($params['select_filter_is_online'])) {
            $users->where('is_online', $params['select_filter_is_online'] == 'on' ? true : false);
        }
        if (!empty($params['select_filter_role'])) {
            $users->where('role_code', $params['select_filter_role']);
        }
        if (isset($params['paginate']) && $params['paginate'] === '0') {
            return $users->get();
        } else {
            return $users->paginate((isset($params['paginate']) ? $params['paginate'] : 5));
        }
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function create($params)
    {
        return User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);
    }

    public function update($params, $id)
    {
        $user = User::find($id);
        if (!empty($params['file_avatar'])) {
            if (!empty($user->avatar)) Storage::delete('public/users/' . $user->avatar);
            $fileName = 'user_' . $user->id . '.jpg';
            Storage::putFileAs('public/users', $params['file_avatar'], $fileName);
            $params['avatar'] = $fileName;
        }
        $params['address'] = $params['ward'] . "-" . $params['district'] . "-" . $params['province'];
        $params['full_name'] = $params['first_name'] . ' ' . $params['last_name'];

        return  $user->update($params);
    }


    public function updateRoleUser($params, $id)
    {
        $user = User::find($id);
        $params['role_code'] = $params['role_code'] ?? null;
        return  $user->update($params);
    }

    public function destroy($params)
    {
        return User::whereIn('id', $params)->delete();
    }
}
