<?php

namespace App\Observers;

use App\Models\Bien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BienObserver
{
    public function created(Bien $bien): void
    {
        $this->logAudit('INSERT', $bien, null, $bien->getAttributes());
    }

    public function updated(Bien $bien): void
    {
        $this->logAudit('UPDATE', $bien, $bien->getOriginal(), $bien->getAttributes());
    }

    public function deleted(Bien $bien): void
    {
        $this->logAudit('DELETE_LOGIC', $bien, $bien->getAttributes(), null);
    }

    private function logAudit(string $accion, Bien $bien, ?array $valoresAnteriores, ?array $valoresNuevos): void
    {
        /* @var \App\Models\User $usuario */
        $usuario = Auth::user();

        \App\Models\LogAuditoria::create([
            'usuario_cedula' => $usuario->cedula ?? 'SISTEMA',
            'accion' => $accion,
            'tabla_afectada' => 'bienes',
            'registro_id' => $bien->id,
            'valores_anteriores' => $valoresAnteriores,
            'valores_nuevos' => $valoresNuevos,
            'direccion_ip' => Request::ip() ?: '127.0.0.1',
        ]);
    }
}
