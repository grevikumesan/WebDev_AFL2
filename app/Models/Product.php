<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'unit',
        'image',
        'stock'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function userWishlist() {
        return $this->belongsToMany(User::class, 'product_user_wishlist');
    }
}
