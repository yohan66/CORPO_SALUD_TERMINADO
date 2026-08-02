<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actas_verificacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero')->unique()->notNullable();
            $table->string('institucion_nombre')->notNullable();
            $table->string('sede_nombre')->notNullable();
            $table->string('sede_codigo')->nullable();
            $table->string('auditor_nombre')->notNullable();
            $table->string('auditor_cedula', 15)->notNullable();
            $table->string('custodio_nombre')->notNullable();
            $table->string('custodio_cedula', 15)->notNullable();
            $table->date('fecha_emision')->notNullable();
            $table->time('hora_emision')->notNullable();
            $table->unsignedInteger('total_asignados')->default(0);
            $table->unsignedInteger('total_verificados')->default(0);
            $table->unsignedInteger('total_faltantes')->default(0);
            $table->string('url_verificacion')->nullable();
            $table->string('hash_documento')->nullable();
            $table->timestamps();
        });

        Schema::create('acta_bien', function (Blueprint $table) {
            $table->unsignedBigInteger('acta_id');
            $table->unsignedBigInteger('bien_id');
            $table->text('observacion_auditoria')->nullable();
            $table->enum('estado_conservacion', ['Excelente', 'Bueno', 'Regular', 'Malo'])->nullable();
            $table->timestamps();

            $table->primary(['acta_id', 'bien_id']);
            $table->foreign('acta_id')->references('id')->on('actas_verificacion')->cascadeOnDelete();
            $table->foreign('bien_id')->references('id')->on('bienes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acta_bien');
        Schema::dropIfExists('actas_verificacion');
    }
};
