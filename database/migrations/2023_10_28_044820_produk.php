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
        Schema::create('tb_produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk');
            $table->text('deskirpsi');
            $table->integer('harga');
            $table->unsignedBigInteger('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('tb_perusahaan')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_produk');
    }
};
