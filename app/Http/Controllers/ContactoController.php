<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Rubro;
use App\Models\SolicitudContacto;
use App\Http\Requests\StoreSolicitudContactoRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;            


class ContactoController extends Controller
{
    // GET /contacto -> muestra el form con rubros activos
    public function create()
    {
        $rubros = Rubro::query()
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['id','nombre']);

        return Inertia::render('Contacto/Index', [
            'rubros' => $rubros,
        ]);
    }

    // POST /contacto -> guarda y redirige con mensaje
    public function store(StoreSolicitudContactoRequest $request)
    {
        $data = $request->validated();

        // Metadatos del servidor
        $data['ip']         = $request->ip();
        $data['user_agent'] = Str::limit((string)$request->userAgent(), 255);
        $data['url_origen'] = $data['url_origen'] ?? $request->headers->get('referer');

        SolicitudContacto::create($data);

        // flash + redirect back a la página del formulario
        return redirect()
            ->route('contacto.create')
            ->with('success', '¡Gracias! Tu solicitud fue enviada correctamente.');
    }


     public function index(Request $request)
    {
        // Filtros desde querystring
        $buscar   = trim((string)$request->query('buscar', ''));
        $rubroId  = $request->query('rubro_id');
        $desea    = $request->query('desea'); // cotizacion|demo
        $perPage  = (int) $request->query('perPage', 10);

        $query = SolicitudContacto::query()
            ->with('rubro') // para mostrar el nombre del rubro
            ->latest('created_at');

        if ($buscar !== '') {
            $query->where(function($q) use ($buscar) {
                $q->where('empresa', 'like', "%{$buscar}%")
                  ->orWhere('nombre_contacto', 'like', "%{$buscar}%")
                  ->orWhere('email_contacto', 'like', "%{$buscar}%")
                  ->orWhere('ruc', 'like', "%{$buscar}%")
                  ->orWhere('mensaje', 'like', "%{$buscar}%");
            });
        }

        if (!empty($rubroId)) {
            $query->where('rubro_id', $rubroId);
        }

        if (in_array($desea, ['cotizacion','demo'], true)) {
            $query->where('desea', $desea);
        }

        $solicitudes = $query->paginate($perPage)->withQueryString();

        $rubros = Rubro::query()
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['id','nombre']);

        return Inertia::render('Contacto/AdminIndex', [
            'solicitudes' => $solicitudes, // paginator de Laravel
            'rubros'      => $rubros,
            'filters'     => [
                'buscar'  => $buscar,
                'rubro_id'=> $rubroId,
                'desea'   => $desea,
                'perPage' => $perPage,
            ],
        ]);
    }
}
