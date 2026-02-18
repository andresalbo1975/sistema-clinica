return new class extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            
            // Claves Foráneas (Foreign Keys)
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            // onDelete('cascade'): Si borras un paciente, se borran sus citas automáticamente.
            
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('restrict');
            // onDelete('restrict'): ¡Prohibido borrar a un médico si tiene citas asignadas!
            
            $table->dateTime('fecha_hora');
            
            // Limitamos los estados posibles para evitar errores de tipeo
            $table->enum('estado', ['Pendiente', 'Completada', 'Cancelada'])->default('Pendiente');
            
            $table->timestamps();
        });
    }
};