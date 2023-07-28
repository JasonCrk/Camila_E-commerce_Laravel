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
        Schema::create('variant_color_image', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('variant_color_id')
                ->constrained('variant_colors')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('variant_image_id')
                ->constrained('variant_images')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_color_image');
    }
};
