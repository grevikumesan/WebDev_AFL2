<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ini adalah tabel "penengah" untuk relasi Many-to-Many
        // antara User dan Product (Wishlist)
        // Namanya harus 'product_user_wishlist' sesuai yang di Model
        Schema::create('product_user_wishlist', function (Blueprint $table) {

            // Bikin kolom 'user_id' yang nyambung ke 'id' di tabel 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Bikin kolom 'product_id' yang nyambung ke 'id' di tabel 'products'
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Bikin 'created_at' (biar tau kapan dia nambahin ke wishlist)
            $table->timestamp('created_at')->nullable();

            // Kunci Primer Gabungan (biar 1 user nggak bisa wishlist 1 produk 2x)
            $table->primary(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_user_wishlist');
    }
};
