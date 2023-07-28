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
        Schema::create('variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->decimal('list_price', $precision = 6, $scale = 2);
            $table->decimal('discount_price', $precision = 6, $scale = 2);
            $table->integer('stock');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
