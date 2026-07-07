<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_enquiries', function (Blueprint $row) {
            $row->id();
            $row->string('name')->nullable();
            $row->string('email')->nullable();
            $row->string('telephone')->nullable();
            $row->string('subject')->nullable();
            $row->text('message')->nullable();
            $row->enum('status', ['pending', 'read', 'responded'])->default('pending');
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_enquiries');
    }
};
