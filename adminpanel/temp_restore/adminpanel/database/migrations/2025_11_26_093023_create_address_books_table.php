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
        Schema::create('address_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // link to Customer table
            $table->boolean('customer_type')->default(1); // 1 = Customer (default)
            $table->string('title', 50)->nullable(); // e.g., Home / Work
            $table->string('name')->nullable();
            $table->string('phone', 15);
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('landmark')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);
            $table->string('country');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_default')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            // Relationship with customers
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_books');
    }
};
