<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citas extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'citas';

    /**
     * Llave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Campos que se pueden asignar de forma masiva.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'tipo_servicio',
        'dia',
        'hora',
    ];

    /**
     * Tipos de datos de las columnas.
     *
     * @var array
     */
    protected $casts = [
        'dia' => 'date',
        'hora' => 'time',
    ];

    /**
     * Obtener la fecha de la cita en formato específico.
     */
    public function getDiaAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Obtener la hora de la cita en formato específico.
     */
    public function getHoraAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i');
    }

    /**
     * Relación con el usuario que crea la cita (si aplica).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
