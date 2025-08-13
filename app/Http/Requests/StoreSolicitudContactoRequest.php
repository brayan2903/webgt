<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitudContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // público
    }

    public function rules(): array
    {
        return [
            // honeypot (campo oculto); si viene con valor, rechazamos
            'website'           => ['prohibited'],

            'empresa'           => ['required','string','max:150'],
            'ruc'               => ['nullable','digits:11'],
            'rubro_id'          => ['nullable','exists:rubros,id'],

            'nombre_contacto'   => ['required','string','max:120'],
            'email_contacto'    => ['required','email','max:150'],
            'telefono_contacto' => ['nullable','string','max:30'],

            'desea'             => ['required','in:cotizacion,demo'],
            'mensaje'           => ['nullable','string','max:65535'],

            'url_origen'        => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'empresa.required'          => 'La empresa es obligatoria.',
            'nombre_contacto.required'  => 'El nombre de contacto es obligatorio.',
            'email_contacto.required'   => 'El email de contacto es obligatorio.',
            'email_contacto.email'      => 'El email no es válido.',
            'ruc.digits'                => 'El RUC debe tener 11 dígitos.',
            'desea.in'                  => 'La opción seleccionada no es válida.',
            'website.prohibited'        => 'Solicitud inválida.',
        ];
    }
}
