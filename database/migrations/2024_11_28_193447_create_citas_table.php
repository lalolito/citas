<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id(); // Identificador único de la cita
            $table->string('nombre', 50); // Nombre del cliente (máximo 50 caracteres)
            $table->string('apellido', 50); // Apellido del cliente (máximo 50 caracteres)
            $table->enum('tipo_documento', ['cc', 'ti', 'cxe', 'pasaporte']) // Tipos de documento válidos
                  ->comment('Tipos de documento: cc (Cédula de ciudadanía), ti (Tarjeta de identidad), cxe (Cédula de extranjería), pasaporte');
            $table->string('numero_documento', 20)->unique(); // Documento único del cliente (máximo 20 caracteres)
            $table->enum('tipo_servicio', ['cambio de aceite', 'revision general', 'mantenimiento general']) // Servicios ofrecidos
                  ->comment('Tipos de servicio: cambio de aceite, revisión general, mantenimiento general');
            $table->date('dia'); // Fecha de la cita
            $table->time('hora'); // Hora de la cita
            $table->timestamps(); // Marca de tiempo para created_at y updated_at

            // Índice combinado opcional para fecha y hora
            $table->unique(['dia', 'hora'], 'citas_dia_hora_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas'); // Eliminar la tabla citas si existe
    }
};
