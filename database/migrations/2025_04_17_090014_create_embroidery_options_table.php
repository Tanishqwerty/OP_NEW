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
        Schema::create('embroideries', function (Blueprint $table) {
            $table->id();
            $table->string('embroidery_name');
            $table->decimal('additional_cost', 8, 2)->default(0.00);
            $table->unsignedBigInteger('warehouse_id')->nullable()->change();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embroidery_options');
    }
};
