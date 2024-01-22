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
        Schema::create('PC', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Case_ID');
            $table->unsignedBigInteger('CPU_ID');
            $table->unsignedBigInteger('CPU_Cooler_ID');
            $table->unsignedBigInteger('GPU_ID');
            $table->unsignedBigInteger('IHD_ID');
            $table->unsignedBigInteger('Memory_ID');
            $table->unsignedBigInteger('Motherboard_ID');
            $table->unsignedBigInteger('PSU_ID');
            $table->timestamps();

            $table->foreign('Case_ID')->references('ID')->on('PC_case')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('CPU_ID')->references('ID')->on('CPU')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('CPU_Cooler_ID')->references('ID')->on('CPU_Cooler')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('GPU_ID')->references('ID')->on('GPU')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('IHD_ID')->references('ID')->on('internal_hard_drive')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Memory_ID')->references('ID')->on('memory')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Motherboard_ID')->references('ID')->on('motherboard')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('PSU_ID')->references('ID')->on('PSU')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PC', function (Blueprint $table) {
            $table->dropForeign(['Case_ID']);
            $table->dropForeign(['CPU_ID']);
            $table->dropForeign(['CPU_Cooler_ID']);
            $table->dropForeign(['GPU_ID']);
            $table->dropForeign(['IHD_ID']);
            $table->dropForeign(['Memory_ID']);
            $table->dropForeign(['Motherboard_ID']);
            $table->dropForeign(['PSU_ID']);
        });

        Schema::dropIfExists('PC');
    }
};
