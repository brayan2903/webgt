<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'rubros';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'nombre',
        'activo',
    ];

    /**
     * Relación: un rubro tiene muchas solicitudes de contacto
     */
    public function solicitudes()
    {
        return $this->hasMany(SolicitudContacto::class, 'rubro_id');
    }
}
