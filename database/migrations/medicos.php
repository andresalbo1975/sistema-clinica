return new class extends Migration
{
    public function up()
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('especialidad', 100);
            $table->string('email', 100)->unique();
            $table->timestamps();
        });
    }
    // ... método down() omitido por brevedad
};