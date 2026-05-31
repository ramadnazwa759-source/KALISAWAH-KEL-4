<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_paket', function (Blueprint $table) {

            $table->string('tagline')->after('deskripsi')->nullable();
            $table->string('hero_image')->after('tagline')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('kategori_paket', function (Blueprint $table) {

            $table->dropColumn([
                'tagline',
                'hero_image'
            ]);
        });
    }
};
