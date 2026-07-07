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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                 // Unique coupon code
            $table->text('description')->nullable();          // Description
            $table->enum('type', ['percentage', 'fixed']);    // Discount type
            $table->decimal('value', 8, 2);                   // Discount value
            $table->decimal('min_amount', 10, 2)->nullable(); // Minimum order amount
            $table->decimal('max_discount', 10, 2)->nullable(); // Max limit for %
            $table->integer('usage_limit')->nullable();       // Total global uses allowed
            $table->integer('used_count')->default(0);        // Used count
            $table->integer('per_user_limit')->nullable();    // Per user limit
            $table->timestamp('start_date')->nullable();      // Start date
            $table->timestamp('end_date')->nullable();        // End date
            $table->boolean('status')->default(true);         // Active / inactive
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
