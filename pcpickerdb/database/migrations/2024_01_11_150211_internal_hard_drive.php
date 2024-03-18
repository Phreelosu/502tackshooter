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
        Schema::create('internal_hard_drive', function (Blueprint $table) {
            $table->id();
            $table->string('Hard_drive_name', 255);
            $table->decimal('Hard_drive_price')->nullable();
            $table->unsignedBigInteger('Hard_drive_capacity_ID');
            $table->unsignedBigInteger('Hard_drive_type_ID');
            $table->integer('Hard_drive_cache')->nullable();
            $table->unsignedBigInteger('Hard_drive_form_factor_ID');
            $table->unsignedBigInteger('Hard_drive_interface_ID');
            $table->timestamps();

            $table->foreign('Hard_drive_capacity_ID')->references('ID')->on('ihd_capacity')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Hard_drive_type_ID')->references('ID')->on('ihd_type')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Hard_drive_form_factor_ID')->references('ID')->on('ihd_form_factor')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Hard_drive_interface_ID')->references('ID')->on('ihd_interface')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_hard_drive', function (Blueprint $table) {
            $table->dropForeign('internal_hard_drive_Hard_drive_capacity_ID_foreign');
            $table->dropForeign('internal_hard_drive_Hard_drive_type_ID_foreign');
            $table->dropForeign('internal_hard_drive_Hard_drive_form_factor_ID_foreign');
            $table->dropForeign('internal_hard_drive_Hard_drive_interface_ID_foreign');
        });

        Schema::dropIfExists('internal_hard_drive');
    }
};
