<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    public function getAll($params)
    {
        $permissions = Permission::where(function ($query) use ($params) {
            if (!empty($params['search']))
                $query->where('permission_name', 'like', '%' . $params['search'] . '%')
                    ->orWhere('permission_code', 'like', '%' . $params['search'] . '%');
        });
        if (isset($params['paginate']) && $params['paginate'] === '0') {
            return $permissions->get();
        } else {
            return $permissions->paginate((isset($params['paginate']) ? $params['paginate'] : 5));
        }
    }

    public function getById($id)
    {
        return Permission::find($id);
    }

    public function create($params)
    {
        $params['permission_code'] = 'P' . str_pad(Permission::max('id') + 1, 5, '0', STR_PAD_LEFT);
        return Permission::create($params);
    }


    public function update($params, $id)
    {
        $permission = Permission::find($id);
        if (!$permission) return false;
        return $permission->update($params);
    }


    public function destroy($params)
    {
        return Permission::whereIn('id', $params)->delete();
    }
}
