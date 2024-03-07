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
        Schema::create('CPU_Cooler', function (Blueprint $table) {
            $table->id();
            $table->string('Cooler_name', 255);
            $table->decimal('Cooler_price', 10, 2);
            $table->integer('Cooler_RPM')->nullable();
            $table->unsignedBigInteger('Cooler_color_ID');
            $table->timestamps();

            $table->foreign('Cooler_color_ID')->references('ID')->on('colors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::hasTable('CPU_Cooler', function (Blueprint $table) {
            $table->dropForeign('CPU_Cooler_Cooler_color_ID_foreign');
        });

        Schema::dropIfExists('CPU_Cooler');
    }
};
