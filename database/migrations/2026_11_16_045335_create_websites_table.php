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
        Schema::create('websites', function (Blueprint $table) {
            $table->id('id_website');
            $table->foreignId('id_template')
                ->constrained('templates', 'id_template')
                ->restrictOnDelete();
            $table->string('name_website');
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->string('whatsapp');
            $table->string('instagram')->nullable();
            $table->string('logo_path')->nullable();
            $table->json('gallery_photos')->nullable();
            $table->json('gallery_prices')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('color_primary', 7)->default('#f6e9df');
            $table->string('color_text', 7)->default('#3b2f2f');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
