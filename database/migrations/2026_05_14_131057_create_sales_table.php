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
            $table->string('invoice_no')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percentage'])
                ->nullable();
            $table->decimal('discount_value', 12, 2)
                ->default(0);
            $table->decimal('discount_amount', 12, 2)
                ->default(0);
            $table->decimal('tax_percentage', 5, 2)
                ->default(0);
            $table->decimal('tax_amount', 12, 2)
                ->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->decimal('paid_amount', 12, 2)
                ->default(0);
            $table->decimal('due_amount', 12, 2)
                ->default(0);
            $table->enum('payment_method', [
                'cash',
                'card',
                'bank_transfer',
                'easypaisa',
                'jazzcash'
            ])->default('cash');
            $table->date('sale_date');
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
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
