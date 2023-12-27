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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_barang_id');
            $table->string('kode')->unique();
            $table->string('nama')->nullable();
            $table->string('satuan')->nullable();
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->integer('stok')->nullable();
            $table->date('expired')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
