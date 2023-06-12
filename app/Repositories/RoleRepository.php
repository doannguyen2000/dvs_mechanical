<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class RoleRepository
{
    public function getAll($params)
    {
        $roles = Role::with('permissions')->where(function ($query) use ($params) {
            if (!empty($params['search']))
                $query->where('role_name', 'like', '%' . $params['search'] . '%')
                    ->orWhere('role_code', 'like', '%' . $params['search'] . '%');
        });
        if (isset($params['paginate']) && $params['paginate'] === 0) {
            return $roles->get();
        } else {
            return $roles->paginate((isset($params['paginate']) ? $params['paginate'] : 5));
        }
        return $roles;
    }

    public function getById($id)
    {
        return Role::with('permissions')->find($id);
    }

    public function create($params)
    {
        $params['role_code'] = 'R' . str_pad(Role::max('id') + 1, 5, '0', STR_PAD_LEFT);
        return Role::create($params);
    }

    function updateRolePermission($params, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return 'Role not foul!';
        }

        if (!empty($params['item_ids'])) {
            $permissionCode = Permission::whereIn('id', explode(',', $params['item_ids']))
                ->pluck('permission_code')
                ->toArray();

            if (!empty($permissionCode)) {
                $role->permissions()->detach($permissionCode);
            }
        }

        if (!empty($params['item_new_ids'])) {
            $permissionCodeNew = Permission::whereIn('id', explode(',', $params['item_new_ids']))
                ->pluck('permission_code')
                ->toArray();
            $permissionExist = array_intersect($permissionCodeNew, $role->permissions->pluck('permission_code')->toArray());
            if (!empty($permissionExist)) return implode(',', $permissionExist) . ' already exist in the ' . $role->role_name;
            $role->permissions()->attach(array_map('trim', $permissionCodeNew));
        }

        return;
    }

    public function update($params, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return false;
        }

        return $role->update($params);
    }

    public function destroy($ids)
    {
        return Role::whereIn('id', array_unique(explode(',', $ids)))->delete();
    }
}
