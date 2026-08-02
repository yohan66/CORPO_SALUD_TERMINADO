<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desincorporaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignBigInteger('bien_id')->constrained('bienes')->restrictOnDelete();
            $table->string('nro_providencia', 50)->unique()->notNullable();
            $table->enum('motivo_baja', ['Obsolescencia', 'Hurto', 'Deterioro', 'Donación', 'Desecho'])->notNullable();
            $table->string('informe_tecnico_url', 255)->notNullable();
            $table->string('aprobado_por_cedula', 15)->notNullable();
            $table->date('fecha_baja')->notNullable();
            $table->timestamp('creado_el')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desincorporaciones');
    }
};
