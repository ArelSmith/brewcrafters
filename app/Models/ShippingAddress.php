<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class ShippingAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address_line',
        'city',
        'province',
        'postal_code',
        'is_default',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
