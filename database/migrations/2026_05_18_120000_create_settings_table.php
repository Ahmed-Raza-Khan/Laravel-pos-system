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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->nullable();
            $table->text('store_address')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->decimal('tax_percentage', 8, 2)->nullable();
            $table->string('currency', 10)->default('PKR');
            $table->string('invoice_prefix')->nullable();
            $table->string('invoice_logo')->nullable();
            $table->text('invoice_terms')->nullable();
            $table->text('invoice_footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
