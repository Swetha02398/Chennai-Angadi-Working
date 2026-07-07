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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->unsignedBigInteger('stock_updated_by')->nullable()->after('stock_status');
            $table->timestamp('stock_updated_at')->nullable()->after('stock_updated_by');

            $table->foreign('stock_updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign(['stock_updated_by']);
            $table->dropColumn(['stock_updated_by', 'stock_updated_at']);
        });
    }
};
