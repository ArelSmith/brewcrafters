<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'subtotal',
        'grandtotal',
        'status',
        'payment_method',
        'tracking_number',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function items() {
        return $this->hasMany(TransactionItem::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
