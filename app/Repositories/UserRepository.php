<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
            $storagePath = storage_path('app/public/users/');

            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }

            $fileName = uniqid() . '.' . $params['file_avatar']->getClientOriginalExtension();

            $imagePath = $storagePath . $fileName;

            $resizedImage = Image::make($params['file_avatar'])->fit(600, 600)->save($imagePath);

            $resizedImage->save($imagePath);

            $params['avatar'] = 'users/' . $fileName;
        }

        $params['address'] = $params['ward'] . "-" . $params['district'] . "-" . $params['province'];
        $params['full_name'] = $params['last_name'] . ' ' . $params['first_name'];

        return  $user->update($params);
    }


    public function updateRoleUser($params, $id)
    {
        $user = User::find($id);
        $params['role_code'] = $params['role_code'] ?? null;
        return  $user->update($params);
    }

    public function destroy($ids)
    {
        return User::whereIn('id', array_unique(explode(',', $ids)))->delete();
    }

    public function updateStatusUser($params)
    {
        return User::whereIn('id', array_unique(explode(',', $params['item_ids'])))->update(['is_online' => $params['status']]);
    }
}
