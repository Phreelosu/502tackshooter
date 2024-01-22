use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PC_case', function (Blueprint $table) {
            $table->id();
            $table->string('Case_name', 255);
            $table->decimal('Case_price', 10, 2);
            $table->unsignedBigInteger('Case_type_ID');
            $table->unsignedBigInteger('Case_color_ID');
            $table->integer('PSU_Watts')->nullable();
            $table->unsignedBigInteger('Side_panel_ID');
            $table->integer('Bay_count')->nullable();
            $table->timestamps();

            $table->foreign('Case_type_ID')->references('ID')->on('case_type')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Case_color_ID')->references('ID')->on('colors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Side_panel_ID')->references('ID')->on('side_panel_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PC_case', function (Blueprint $table) {
            $table->dropForeign('PC_case_Case_type_ID_foreign');
            $table->dropForeign('PC_case_Case_color_ID_foreign');
            $table->dropForeign('PC_case_Side_panel_ID_foreign');
        });

        Schema::dropIfExists('PC_case');
    }
}
