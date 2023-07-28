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
        Schema::create('whish_list_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('whish_list_id')
                ->constrained('whish_lists')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('variant_id')
                ->constrained('variants')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whish_list_items');
    }
};
