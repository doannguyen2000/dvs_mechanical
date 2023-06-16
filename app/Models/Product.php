<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_code',
        'product_price',
        'product_sale',
        'product_description',
        'product_status',
        'product_type_code'
    ];

    public function productImages()
    {
        return $this->hasMany(
            ProductImage::class,
            'product_code',
            'product_code'
        );
    }

    public function productType()
    {
        return $this->hasOne(
            ProductType::class,
            'product_type_code',
            'product_type_code'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'product_categories',
            'product_code',
            'category_code',
            'product_code',
            'category_code',
        );
    }
}
