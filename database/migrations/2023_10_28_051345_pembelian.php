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
        Schema::create('tb_pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->date('tgl_pembelian');
            $table->unsignedBigInteger('id_pemasok');
            $table->foreign('id_pemasok')->references('id_pemasok')->on('tb_pemasok')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('jumlah_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian');
    }
};
