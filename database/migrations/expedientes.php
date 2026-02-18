return new class extends Migration
{
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            
            // Relación 1 a 1: Una cita solo puede tener UN expediente.
            $table->foreignId('cita_id')->unique()->constrained('citas')->onDelete('cascade');
            
            $table->text('diagnostico');
            $table->text('receta_medica')->nullable();
            
            $table->timestamps();
        });
    }
};