<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll($params)
    {
        $categories = Category::where(function ($query) use ($params) {
            if (!empty($params['search'])) {
                $query->where('category_name', 'like', '%' . $params['search'] . '%')
                    ->orWhere('category_code', 'like', '%' . $params['search'] . '%');
            }
            if (!empty($params['status']) && in_array($params['status'], ['0', '1'])) {
                $query->where('status', $params['status']);
            }
        });
        if (isset($params['paginate']) && $params['paginate'] === '0') {
            return $categories->get();
        } else {
            return $categories->paginate((isset($params['paginate']) ? $params['paginate'] : 5));
        }
    }

    public function getById($id)
    {
        return Category::find($id);
    }

    public function create($params)
    {
        $params['category_code'] = 'C' . str_pad(Category::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $params['status'] = isset($params['status']) && $params['status'] == 'on' ?  true : false;
        return Category::create($params);
    }


    public function update($params, $id)
    {
        $category = Category::find($id);
        if (!$category) return false;
        $params['status'] = isset($params['status']) && $params['status'] == 'on' ?  true : false;
        return $category->update($params);
    }


    public function destroy($ids)
    {
        return Category::whereIn('id', array_unique(explode(',', $ids)))->delete();
    }
}
