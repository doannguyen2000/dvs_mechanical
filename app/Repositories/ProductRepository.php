<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;

class ProductRepository
{
    public function getAll($params)
    {
        $products = Product::where(function ($query) use ($params) {
            if (!empty($params['search']))
                $query->where('product_name', 'like', '%' . $params['search'] . '%')
                    ->orWhere('product_code', 'like', '%' . $params['search'] . '%');
        });
        if (isset($params['paginate']) && $params['paginate'] === '0') {
            return $products->get();
        } else {
            return $products->paginate((isset($params['paginate']) ? $params['paginate'] : 5));
        }
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function create($params)
    {
        $params['category_code'] = 'P' . str_pad(Product::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $params['status'] = isset($params['status']) && $params['status'] == 'on' ?  true : false;
        return Product::create($params);
    }


    public function update($params, $id)
    {
        $product = Product::find($id);
        if (!$product) return false;
        $params['status'] = isset($params['status']) && $params['status'] == 'on' ?  true : false;
        return $product->update($params);
    }


    public function destroy($params)
    {
        return Product::whereIn('id', $params)->delete();
    }
}
