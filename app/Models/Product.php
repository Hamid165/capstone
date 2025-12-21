<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price',
        'stock', 'image', 'is_best_seller'
    ];

    protected $casts = [
        'is_best_seller' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
