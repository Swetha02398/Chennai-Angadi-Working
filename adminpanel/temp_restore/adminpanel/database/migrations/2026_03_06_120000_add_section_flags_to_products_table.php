<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('top_selling')->default(0)->after('featured');
            $table->tinyInteger('trending_product')->default(0)->after('top_selling');
            $table->tinyInteger('hot_deal')->default(0)->after('trending_product');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['top_selling', 'trending_product', 'hot_deal']);
        });
    }
};
