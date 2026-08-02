<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAuditoria extends Model
{
    protected $table = 'logs_auditoria';

    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_cedula',
        'accion',
        'tabla_afectada',
        'registro_id',
        'valores_anteriores',
        'valores_nuevos',
        'direccion_ip',
        'creado_el',
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
        'direccion_ip' => 'string',
        'creado_el' => 'datetime',
    ];
}
