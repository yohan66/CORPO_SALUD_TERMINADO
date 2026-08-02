<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ActaBien extends Pivot
{
    protected $table = 'acta_bien';

    protected $fillable = [
        'acta_id',
        'bien_id',
        'observacion_auditoria',
        'estado_conservacion',
    ];
}
