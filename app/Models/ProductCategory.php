<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function parent() {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(ProductCategory::class,'parent_id');
    }
}
