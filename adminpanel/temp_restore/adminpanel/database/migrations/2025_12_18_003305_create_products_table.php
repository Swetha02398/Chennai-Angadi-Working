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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('childcategory_id')->nullable();
            $table->string('productname');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('hsn', 20)->nullable();
            $table->decimal('gst', 5, 2)->nullable();
            $table->decimal('sgst', 5, 2)->nullable();
            $table->decimal('igst', 5, 2)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('featured')->default(0);
            $table->json('productimage')->nullable();   // 👈 COMMON images
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->timestamps();

// Foreign Key Constraints

    $table->foreign('category_id')
          ->references('id')
          ->on('main_categories')
          ->restrictOnDelete();

    $table->foreign('subcategory_id')
          ->references('id')
          ->on('sub_categories')
          ->restrictOnDelete();

    $table->foreign('childcategory_id')
          ->references('id')
          ->on('child_categories')
          ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
