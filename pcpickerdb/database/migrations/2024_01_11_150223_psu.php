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
        Schema::create('PSU', function (Blueprint $table) {
            $table->id();
            $table->string('PSU_name', 255)->nullable(false);
            $table->decimal('PSU_price', 10, 2)->nullable(false);
            $table->unsignedBigInteger('PSU_type_ID');
            $table->unsignedBigInteger('PSU_efficiency_ID');
            $table->integer('PSU_watts')->nullable();
            $table->unsignedBigInteger('Modular_ID');
            $table->unsignedBigInteger('PSU_color_ID');
            $table->timestamps();

            $table->foreign('PSU_type_ID')->references('ID')->on('psu_type')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('PSU_efficiency_ID')->references('ID')->on('psu_efficiency')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Modular_ID')->references('ID')->on('PSU_Modular')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('PSU_color_ID')->references('ID')->on('colors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PSU', function (Blueprint $table) {
            $table->dropForeign(['PSU_type_ID']);
            $table->dropForeign(['PSU_efficiency_ID']);
            $table->dropForeign(['Modular_ID']);
            $table->dropForeign(['PSU_color_ID']);
        });

        Schema::dropIfExists('PSU');
    }
};
