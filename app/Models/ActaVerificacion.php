<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActaVerificacion extends Model
{
    protected $table = 'actas_verificacion';

    public $timestamps = true;

    protected $fillable = [
        'numero',
        'institucion_nombre',
        'sede_nombre',
        'sede_codigo',
        'auditor_nombre',
        'auditor_cedula',
        'custodio_nombre',
        'custodio_cedula',
        'fecha_emision',
        'hora_emision',
        'total_asignados',
        'total_verificados',
        'total_faltantes',
        'url_verificacion',
        'hash_documento',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'hora_emision' => 'datetime:H:i',
    ];

    public function bienes()
    {
        return $this->belongsToMany(Bien::class, 'acta_bien', 'acta_id', 'bien_id')
            ->withPivot('observacion_auditoria', 'estado_conservacion');
    }
}
