<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bienes';

    public $timestamps = false;

    protected $fillable = [
        'codigo_patrimonial',
        'descripcion',
        'serial_fabrica',
        'valor_adquisicion',
        'estado_conservacion',
        'estatus',
        'custodio_cedula',
        'categoria',
        'ubicacion',
    ];

    const DELETED_AT = 'eliminado_el';

    protected $casts = [
        'valor_adquisicion' => 'decimal:2',
    ];

    public function desincorporaciones()
    {
        return $this->hasMany(Desincorporacion::class, 'bien_id');
    }
}
