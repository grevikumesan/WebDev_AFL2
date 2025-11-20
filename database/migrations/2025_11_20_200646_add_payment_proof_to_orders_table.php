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
        Schema::table('orders', function (Blueprint $table) {
            // Menambah kolom bukti bayar
            $table->string('payment_proof')->nullable()->after('total_price');

            // Mengubah kolom status agar sesuai alur baru
            // Note: Jika error mengubah enum di database tertentu, bisa pakai string biasa atau raw query.
            // Disini kita ubah defaultnya jadi 'unpaid'
            $table->string('status')->default('unpaid')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
        });
    }
};
