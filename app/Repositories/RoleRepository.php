<?php

namespace App\Repositories;

use App\Models\Role;


class RoleRepository
{
    public function getAll($params)
    {
        $roles = Role::where(function ($query) use ($params) {
            if (!empty($params['search_role']))
                $query->where('role_name', 'like', '%' . $params['search_role'] . '%')
                    ->orWhere('role_code', 'like', '%' . $params['search_role'] . '%');
        })->paginate(5);
        return $roles;
    }

    public function getById($id)
    {
        return Role::find($id);
    }

    public function create($params)
    {
        $params['role_code'] = 'R' . str_pad(Role::max('id') + 1, 5, '0', STR_PAD_LEFT);
        return Role::create($params);
    }


    public function update($params, $id)
    {
        $role = Role::find($id);
        if (!$role) return false;
        return $role->update($params);
    }


    public function destroy($params)
    {
        return Role::whereIn('id', $params)->delete();
    }
}
