<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

             // Link to customer table
            $table->unsignedBigInteger('customer_id')->nullable();

             // Guest or Registered
            $table->boolean('user_type')
            ->default(false)
            ->comment('0 = guest, 1 = registered');

             // Product details
            $table->unsignedBigInteger('product_id');

             // Quantity and pricing
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_add_time', 10, 2);

             // GST placeholder (from Product.tax_rate)
            $table->boolean('taxable')->default(false);
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();

            // Row total = price * qty (+ tax later)
            $table->decimal('row_total', 10, 2)->nullable();
            $table->boolean('status')->default(true);         // Active / inactive

            $table->timestamps();

            // Foreign keys
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
