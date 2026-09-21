<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_event_variant', function (Blueprint $table) {
            $table->foreignId('sales_event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->decimal('event_price', 10, 2)->nullable();

            $table->primary(['sales_event_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_event_variant');
    }
};
