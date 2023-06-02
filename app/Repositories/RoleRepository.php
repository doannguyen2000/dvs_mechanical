<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\RolePermission;

class RoleRepository
{
    public function getAll($params)
    {
        $roles = Role::with('permissions')->where(function ($query) use ($params) {
            if (!empty($params['role_search']))
                $query->where('role_name', 'like', '%' . $params['role_search'] . '%')
                    ->orWhere('role_code', 'like', '%' . $params['role_search'] . '%');
        });
        if (isset($params['role_paginate']) && $params['role_paginate'] === '0') {
            return $roles->get();
        } else {
            return $roles->paginate((isset($params['role_paginate']) ? $params['role_paginate'] : 5));
        }
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

        if (!$role) {
            return false;
        }

        if (!empty($params['permission_code'])) {
            $permissionCode = RolePermission::whereNotIn('permission_code', explode(',', $params['permission_code']))
                ->where('role_code', $role->role_code)
                ->pluck('permission_code')
                ->toArray();

            if (!empty($permissionCode)) {
                $role->permissions()->detach($permissionCode);
            }
        } else {
            $role->permissions()->detach();
        }

        if (!empty($params['permission_code_new'])) {
            $permissionCodeNew = array_map('trim', array_unique(
                isset($permissionCode)
                    ? array_diff(explode(',', $params['permission_code_new']), explode(',', $params['permission_code']))
                    : explode(',', $params['permission_code_new'])
            ));

            $role->permissions()->attach($permissionCodeNew);
        }

        return $role->update($params);
    }

    public function destroy($params)
    {
        return Role::whereIn('id', $params)->delete();
    }
}
