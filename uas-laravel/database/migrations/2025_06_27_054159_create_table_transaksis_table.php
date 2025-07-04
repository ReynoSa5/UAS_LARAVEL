<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('table_transaksis', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->string('no_transaksi',50);
            $table->date('tgl_transaksi');
            $table->bigInteger('total_bayar');
            $table->integer('id_user');
            $table->integer('id_barang');
            $table->timestamps();
            $table->foreign('id_user')->references('id_user')->on('table_users');
            $table->foreign('id_barang')->references('id_barang')->on('table_barangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_transaksis');
    }
};
