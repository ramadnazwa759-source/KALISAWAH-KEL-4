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
            Schema::create('profil_wisata', function (Blueprint $table) {
        $table->id('id');
        $table->string('nama_wisata');
        $table->text('deskripsi');
        $table->string('alamat');
        $table->string('no_hp');
        $table->string('email');
        $table->string('instagram')->nullable();
        $table->string('tiktok')->nullable();
        $table->text('maps_link')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_wisata');
    }
};
