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
        // Check if table already exists to avoid conflicts
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                // $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
                // $table->foreignId('pattern_id')->constrained()->onDelete('cascade');
                // $table->foreignId('shade_id')->constrained()->onDelete('cascade');
                // $table->foreignId('size_id')->constrained()->onDelete('cascade');
                // $table->foreignId('embroidery_id')->nullable()->constrained()->onDelete('set null');
                // $table->boolean('is_embroidery')->default(false);
                $table->string('name');
                $table->decimal('price', 10, 2);
                // $table->decimal('embroidery_charges', 10, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
