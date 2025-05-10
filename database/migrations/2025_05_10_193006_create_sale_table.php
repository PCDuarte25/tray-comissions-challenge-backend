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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 8, 2);
            $table->dateTime('sale_date');
            $table->decimal('commission', 8, 2);
            $table->boolean('reported')->default(false);
            $table->timestamps();

            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('created_by_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
