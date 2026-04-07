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
    Schema::create('booking', function (Blueprint $table) {
    $table->id();
    $table->string('kode_booking');
    $table->string('nama_pemesan');
    $table->string('no_hp');
    $table->foreignId('id_paket')->constrained('paket_wisata');
    $table->date('tanggal_kunjungan');
    $table->time('jam');
    $table->integer('jumlah_orang');
    $table->integer('jumlah_tenda')->nullable();
    $table->text('catatan')->nullable();
    $table->string('status_booking');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
