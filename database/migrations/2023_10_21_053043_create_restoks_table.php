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
        Schema::create('restoks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('suplier_id')->nullable();
            $table->bigInteger('barang_id');
            $table->bigInteger('harga_beli_lama');
            $table->bigInteger('harga_beli_baru');
            $table->bigInteger('harga_jual_lama');
            $table->bigInteger('harga_jual_baru');
            $table->integer('stok_lama');
            $table->integer('stok_baru');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restoks');
    }
};
