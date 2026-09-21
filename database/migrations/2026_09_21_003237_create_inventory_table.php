<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->foreignId('variant_id')->primary()->constrained('product_variants')->cascadeOnDelete();
            $table->integer('quantity_on_hand')->default(0);
            $table->integer('quantity_reserved')->default(0);
            $table->integer('reorder_threshold')->default(0);
            $table->timestamp('updated_at')->nullable();
        });

        DB::statement('ALTER TABLE inventory ADD CONSTRAINT chk_inventory_quantities_non_negative CHECK (quantity_on_hand >= 0 AND quantity_reserved >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
