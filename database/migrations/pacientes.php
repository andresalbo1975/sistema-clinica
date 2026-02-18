use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id(); // Crea una Primary Key autoincremental
            $table->string('nombre', 100);
            $table->string('rut_dni', 20)->unique(); // unique() evita duplicados en BD
            $table->string('email', 100)->unique();
            $table->string('telefono', 20)->nullable(); // nullable() significa que es opcional
            $table->date('fecha_nacimiento');
            $table->timestamps(); // Crea automáticamente las columnas 'created_at' y 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacientes'); // Permite revertir la migración
    }
};