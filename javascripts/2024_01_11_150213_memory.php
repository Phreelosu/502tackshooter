use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memory', function (Blueprint $table) {
            $table->id();
            $table->string('Memory_name', 255);
            $table->decimal('Memory_price', 10, 2);
            $table->integer('Memory_speed')->nullable();
            $table->unsignedBigInteger('Memory_modules_ID');
            $table->unsignedBigInteger('Memory_color_ID');
            $table->integer('First_word_latency')->nullable();
            $table->integer('CAS_latency')->nullable();
            $table->timestamps();

            $table->foreign('Memory_modules_ID')->references('ID')->on('memory_modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Memory_color_ID')->references('ID')->on('colors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memory', function (Blueprint $table) {
            $table->dropForeign('memory_Memory_modules_ID_foreign');
            $table->dropForeign('memory_Memory_color_ID_foreign');
        });

        Schema::dropIfExists('memory');
    }
}
