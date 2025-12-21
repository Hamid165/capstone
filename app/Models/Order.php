<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipping_rate_id',
        'total_price',
        'snap_token',
        'payment_status',
        'shipping_status',
        'resi_number',
        'shipping_address_detail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingRate()
    {
        return $this->belongsTo(ShippingRate::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
