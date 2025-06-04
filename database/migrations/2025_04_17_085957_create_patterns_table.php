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
        Schema::create('patterns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Round Neck with 3 buttons
            $table->string('code')->nullable(); // optional unique code
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->string('status')->default('Active');
            $table->unsignedBigInteger('warehouse_id')->nullable()->change();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patterns');
    }
};
