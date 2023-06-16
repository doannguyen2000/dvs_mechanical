<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductRepository
{
    public function getAll($params)
    {
        $products = Product::with('productType')->select('*')->addSelect(DB::raw('(SELECT product_images.product_image_url FROM product_images WHERE product_images.product_code = products.product_code AND product_images.is_featured_image = true LIMIT 1) AS featured_image_url'))
            ->where(function ($query) use ($params) {
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
        return Product::with(['productImages', 'categories'])->find($id);
    }

    public function create($params)
    {
        $params['product_code'] = 'PD' . str_pad(Product::max('id') + 1, 4, '0', STR_PAD_LEFT);
        $params['status'] = isset($params['status']) && $params['status'] ?  true : false;
        return Product::create($params);
    }


    public function update($params, $id)
    {
        $product = Product::find($id);

        if (count($product->productImages) - count($params['product_image_ids'] ?? []) + count($params['product_new_images'] ?? []) > 6) {
            return ['status' => false, 'message' => 'Limited product 6 photos'];
        }

        $imgDelete = ProductImage::where(function ($query) use ($params) {
            if (!empty($params['product_image_ids']))
                $query->whereNotIn('id', $params['product_image_ids']);
        })
            ->where('product_code', $product->product_code)
            ->pluck('product_image_url')
            ->toArray();

        foreach ($imgDelete as $imgUrl) {
            $filePath = 'public/products/' . $imgUrl;
            Storage::delete($filePath);
        }

        ProductImage::where(function ($query) use ($params) {
            if (!empty($params['product_image_ids'])) {
                $query->whereNotIn('id', $params['product_image_ids']);
            }
        })->where('product_code', $product->product_code)
            ->delete();

        if (!empty($params['product_new_images'])) {
            $imgNew = [];

            foreach ($params['product_new_images'] as $image) {

                $storagePath = storage_path('app/public/products/');

                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                $fileName = $product->product_code . "_" . uniqid() . '.' . $image->getClientOriginalExtension();

                $imagePath = $storagePath . $fileName;

                $resizedImage = Image::make($image)->fit(600, 600)->save($imagePath);

                $resizedImage->save($imagePath);

                array_push($imgNew, 'products/' . $fileName);
            }

            if (!empty($imgNew)) {
                $imgNew = array_map(function ($key, $item) use ($product) {
                    return [
                        'product_code' => $product->product_code,
                        'product_image_url' => $item,
                        'is_featured_image' => ($key === 0 && $product->productImages->where('is_featured_image', true)->count() === 0) ? true : false
                    ];
                }, array_keys($imgNew), $imgNew);
                ProductImage::insert($imgNew);
            }
        }

        $params['status'] = isset($params['status']) && $params['status'] == 'on' ?  true : false;
        $product->update($params);
        return ['status' => true, 'message' => 'Updated product success'];
    }

    public function updateProductCategory($params, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return 'product not foul!';
        }

        if (!empty($params['item_ids'])) {
            $categoryCode = Category::whereIn('id', explode(',', $params['item_ids']))
                ->pluck('category_code')
                ->toArray();

            if (!empty($categoryCode)) {
                $product->categories()->detach($categoryCode);
            }
        }

        if (!empty($params['item_new_ids'])) {
            $categoryCodeNew = Category::whereIn('id', explode(',', $params['item_new_ids']))
                ->pluck('category_code')
                ->toArray();
            $categoryExists = array_intersect($categoryCodeNew, $product->categories->pluck('category_code')->toArray());
            if (!empty($categoryExists)) return implode(',', $categoryExists) . ' already exist in the ' . $product->product_name;
            $product->categories()->attach(array_map('trim', $categoryCodeNew));
        }

        return;
    }


    public function destroy($ids)
    {
        return Product::whereIn('id', array_unique(explode(',', $ids)))->delete();
    }
}
