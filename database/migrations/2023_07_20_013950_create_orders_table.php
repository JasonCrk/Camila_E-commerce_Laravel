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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('full_name', 100);
            $table->string('transaction_id');
            $table->decimal('full_payment', $precision = 7, $scale = 2);
            $table->string('shipping_name');
            $table->string('shipping_price');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->integer('telephone');
            $table->integer('zip_code');
            $table
                ->foreignUuid('shipping_id')
                ->constrained('shippings')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('city_id')
                ->constrained('cities')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('region_id')
                ->constrained('regions')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
