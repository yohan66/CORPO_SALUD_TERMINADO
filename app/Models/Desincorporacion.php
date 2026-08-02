<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desincorporacion extends Model
{
    protected $table = 'desincorporaciones';

    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = null;

    protected $fillable = [
        'bien_id',
        'nro_providencia',
        'motivo_baja',
        'informe_tecnico_url',
        'aprobado_por_cedula',
        'fecha_baja',
        'creado_el',
    ];

    protected $casts = [
        'fecha_baja' => 'date',
        'creado_el' => 'datetime',
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }
}
