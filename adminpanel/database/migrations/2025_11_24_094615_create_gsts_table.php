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
        Schema::create('gsts', function (Blueprint $table) {
            $table->id();
            $table->decimal('default_tax_rate', 5, 2)->default(0);
            $table->boolean('enable_auto_gst')->default(true);
            $table->json('gst_rules')->nullable(); // Example: {"b2b":"igst","b2c":"cgst_sgst"}
            $table->enum('rounding_method', ['none', 'nearest', 'up', 'down'])->default('nearest');
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('gsts');
    }
};
