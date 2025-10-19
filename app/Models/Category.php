<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    public function products() {
        // 'category_id' adalah foreign key di tabel products
        // 'id' adalah primary key di tabel categories
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
