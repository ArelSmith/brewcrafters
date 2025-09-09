<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductCategory;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'weight',
        'price',
        'stock',
        'image',
        'parent_id',
        'child_id',
        'child_2_id',
        'child_3_id',
        'status',
    ];

    public function categories () {
        return $this->belongsToMany(ProductCategory::class, 'product_category_product');
    }
}
