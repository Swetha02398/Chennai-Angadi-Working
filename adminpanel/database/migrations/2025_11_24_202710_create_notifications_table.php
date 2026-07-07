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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['normal', 'high', 'admin'])->default('normal');
            $table->string('title');
            $table->text('message');
            $table->unsignedBigInteger('from_id')->nullable();
            $table->enum('from_role', ['admin', 'customer'])->nullable();
            $table->string('ref_id')->nullable();
            $table->json('extra_data')->nullable();
           $table->enum('status', ['unread', 'read']) ->default('unread')->change(); // optional (course_id, wallet_id etc.)
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
        Schema::dropIfExists('notifications');
    }
};
