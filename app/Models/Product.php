<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductCategory;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ["id"];

    public function category () {
        return $this->hasOne(ProductCategory::class);
    }
}
