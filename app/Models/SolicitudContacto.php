<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudContacto extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'solicitudes_contacto';

    // Campos que se pueden asignar en masa (mass assignment)
    protected $fillable = [
        'empresa',
        'ruc',
        'rubro_id',
        'nombre_contacto',
        'email_contacto',
        'telefono_contacto',
        'desea',
        'mensaje',
        'ip',
        'user_agent',
        'url_origen',
    ];

    /**
     * Relación: una solicitud de contacto pertenece a un rubro
     */
    public function rubro()
    {
        return $this->belongsTo(Rubro::class, 'rubro_id');
    }
}
