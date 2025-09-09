<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function messages() {
        return $this->hasMany(ReportMessage::class);
    }
}
