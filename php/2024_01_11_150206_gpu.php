use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GPU', function (Blueprint $table) {
            $table->id();
            $table->string('GPU_name', 255);
            $table->decimal('GPU_price', 10, 2);
            $table->string('GPU_chipset', 255)->nullable();
            $table->unsignedBigInteger('GPU_memory_ID');
            $table->float('GPU_core_clock')->nullable();
            $table->float('GPU_boost_clock')->nullable();
            $table->unsignedBigInteger('GPU_color_ID');
            $table->decimal('GPU_length', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('GPU_memory_ID')->references('ID')->on('GPU_Memory')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('GPU_color_ID')->references('ID')->on('colors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('GPU', function (Blueprint $table) {
            $table->dropForeign('GPU_GPU_memory_ID_foreign');
            $table->dropForeign('GPU_GPU_color_ID_foreign');
        });

        Schema::dropIfExists('GPU');
    }
}
