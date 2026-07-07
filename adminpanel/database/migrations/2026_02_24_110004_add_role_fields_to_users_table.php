<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new role fields
            $table->foreignId('role_id')->nullable()->after('profile_image')->constrained('roles')->onDelete('set null');
            $table->enum('role_type', ['admin', 'superadmin'])->default('admin')->after('role_id');
        });

        // Drop old role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'role_type']);
            $table->enum('role', ['admin', 'manager', 'staff'])->default('staff')->after('password');
        });
    }
};
