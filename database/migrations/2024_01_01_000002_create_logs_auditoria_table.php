<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs_auditoria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usuario_cedula', 15)->notNullable();
            $table->enum('accion', ['INSERT', 'UPDATE', 'DELETE_LOGIC', 'AUTH_LOGIN'])->notNullable();
            $table->string('tabla_afectada', 50)->notNullable();
            $table->unsignedBigInteger('registro_id')->notNullable();
            $table->json('valores_anteriores')->nullable();
            $table->json('valores_nuevos')->nullable();
            $table->string('direccion_ip', 45)->notNullable();
            $table->timestamp('creado_el')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs_auditoria');
    }
};
