<?php

namespace App\Repositories;

use App\Models\ProductType;

class ProductTypeRepository
{
    public function getAll($params)
    {
        $productTypes = ProductType::where(function ($query) use ($params) {
            if (!empty($params['search']))
                $query->where('product_type_code', 'like', '%' . $params['search'] . '%')
                    ->orWhere('product_type_name', 'like', '%' . $params['search'] . '%');
        });
        if (isset($params['paginate']) && $params['paginate'] === 0) {
            return $productTypes->get();
        } else {
            return $productTypes->paginate((isset($params['paginate']) ? $params['paginate'] : 5));
        }
        return $productTypes;
    }

    public function getById($id)
    {
        return ProductType::with('permissions')->find($id);
    }

    public function create($params)
    {
        $params['role_code'] = 'R' . str_pad(ProductType::max('id') + 1, 5, '0', STR_PAD_LEFT);
        return ProductType::create($params);
    }

    function updateRolePermission($params, $id)
    {
    }

    public function update($params, $id)
    {
    }

    public function destroy($ids)
    {
        return ProductType::whereIn('id', array_unique(explode(',', $ids)))->delete();
    }
}
