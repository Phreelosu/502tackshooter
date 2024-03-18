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
        Schema::create('motherboard', function (Blueprint $table) {
            $table->id();
            $table->string('Motherboard_name', 255);
            $table->decimal('Motherboard_price')->nullable();
            $table->string('Motherboard_socket', 50)->nullable();
            $table->unsignedBigInteger('Motherboard_form_factor_ID');
            $table->unsignedBigInteger('Motherboard_max_memory_ID');
            $table->unsignedBigInteger('Motherboard_memory_slots_ID');
            $table->unsignedBigInteger('Motherboard_color_ID');
            $table->timestamps();

            $table->foreign('Motherboard_form_factor_ID')->references('ID')->on('mobo_form_factor')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Motherboard_max_memory_ID')->references('ID')->on('mobo_max_memory')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Motherboard_memory_slots_ID')->references('ID')->on('mobo_memory_slots')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Motherboard_color_ID')->references('ID')->on('colors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motherboard', function (Blueprint $table) {
            $table->dropForeign('motherboard_Motherboard_form_factor_ID_foreign');
            $table->dropForeign('motherboard_Motherboard_max_memory_ID_foreign');
            $table->dropForeign('motherboard_Motherboard_memory_slots_ID_foreign');
            $table->dropForeign('motherboard_Motherboard_color_ID_foreign');
        });

        Schema::dropIfExists('motherboard');
    }
};
