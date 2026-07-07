<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Alter the condition_type enum to include 'final_amount'
        DB::statement("ALTER TABLE `shipping_rules` MODIFY `condition_type` ENUM('weight', 'price', 'final_amount') NOT NULL DEFAULT 'final_amount'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE `shipping_rules` MODIFY `condition_type` ENUM('weight', 'price') NOT NULL");
    }
};
