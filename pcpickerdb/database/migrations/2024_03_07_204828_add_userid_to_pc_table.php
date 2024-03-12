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
        Schema::table('pc', function (Blueprint $table) {
            // Add User ID column
            $table->unsignedBigInteger('user_id')->nullable();

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pc', function (Blueprint $table) {
            // Drop User ID column
            $table->dropColumn('user_id');
        });
    }
};
