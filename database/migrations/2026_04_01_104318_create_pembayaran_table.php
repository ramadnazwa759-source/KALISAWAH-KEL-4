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
                Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_booking')->constrained('booking');
            $table->string('metode');
            $table->string('bukti_pembayaran_dp')->nullable();
            $table->date('tanggal_dp')->nullable();
            $table->decimal('total_harga_awal', 10, 2);
            $table->foreignId('id_diskon')->nullable()->constrained('diskon');
            $table->decimal('total_harga_akhir', 10, 2);
            $table->string('bukti_pelunasan')->nullable();
            $table->string('status');
            $table->date('tanggal_pelunasan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
