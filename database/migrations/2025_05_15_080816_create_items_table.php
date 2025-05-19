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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('warranty_code')->unique();
            $table->string('unit')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('customer')->nullable();
            $table->string('po_number')->nullable();
            $table->string('so_number')->nullable();
            $table->date('expired_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('installed_date')->nullable();
            $table->date('handover_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
