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
        Schema::create('shades', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Example: Maroon/Pink
            $table->string('code')->nullable(); // Optional: SHD001
            $table->string('description')->nullable();
            $table->string('status')->default('Active');
            $table->decimal('base_price', 10, 2)->default(0);
            $table->unsignedBigInteger('warehouse_id')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shades');
    }
};
