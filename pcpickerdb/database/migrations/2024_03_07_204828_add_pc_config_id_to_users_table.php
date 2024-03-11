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
        Schema::table('users', function (Blueprint $table) {
            // Add PC config ID column
            $table->unsignedBigInteger('pc_config_id')->nullable();

            // Add foreign key constraint
            $table->foreign('pc_config_id')->references('id')->on('pc')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop PC config ID column
            $table->dropColumn('pc_config_id');
        });
    }
};