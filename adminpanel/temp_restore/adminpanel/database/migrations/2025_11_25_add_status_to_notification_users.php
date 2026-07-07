<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notification_users', function (Blueprint $table) {
            if (!Schema::hasColumn('notification_users', 'status')) {
                $table->enum('status', ['read', 'unread'])->default('unread')->after('role');
            }
        });
    }

    public function down()
    {
        Schema::table('notification_users', function (Blueprint $table) {
            if (Schema::hasColumn('notification_users', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
