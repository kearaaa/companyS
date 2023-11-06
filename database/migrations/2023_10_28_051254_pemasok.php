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
        Schema::dropIfExists('tb_pemasok'); // Hapus tabel jika sudah ada
        Schema::create('tb_pemasok', function (Blueprint $table) {
            $table->id('id_pemasok');
            $table->string('nama_pemasok');
            $table->text('alamat');
            $table->string('email');
            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pemasok');
    }
};
