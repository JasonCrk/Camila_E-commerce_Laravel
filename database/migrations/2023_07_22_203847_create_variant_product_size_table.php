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
        Schema::create('variant_product_size', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('variant_id')
                ->constrained('variants')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('size_id')
                ->constrained('sizes')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_product_size');
    }
};
