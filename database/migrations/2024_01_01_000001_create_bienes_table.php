<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bienes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_patrimonial', 50)->unique()->notNullable();
            $table->text('descripcion')->notNullable();
            $table->string('serial_fabrica', 100)->nullable();
            $table->unsignedDecimal('valor_adquisicion', 15, 2)->notNullable();
            $table->enum('estado_conservacion', ['Excelente', 'Bueno', 'Regular', 'Malo'])->notNullable();
            $table->enum('estatus', ['Activo', 'En Proceso de Desincorporación', 'Desincorporado', 'Transferido'])->default('Activo')->notNullable();
            $table->string('custodio_cedula', 15)->notNullable();
            $table->timestamp('creado_el')->useCurrent();
            $table->timestamp('eliminado_el')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bienes');
    }
};
