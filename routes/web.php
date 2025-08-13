<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/solicitudes-contacto', [ContactoController::class, 'index'])
    ->name('solicitudes.index');


});

    Route::get('/', fn () => Inertia::render('Publico/index'))->name('inicio');

    Route::get('/facturacion', fn () => Inertia::render('Publico/Facturacion'))->name('facturacion');
    Route::get('/modulos', fn () => Inertia::render('Publico/Modulos'))->name('modulos');

    // Route::get('/gestioncomercial', fn () => Inertia::render('Publico/Gestioncomercial'))->name('gestion-comercial');




    Route::get('/modulos', fn () => Inertia::render('Publico/Modulos'))->name('modulos');

    // Grupo de rutas para módulos
    Route::prefix('modulos')->name('modulos.')->group(function () {
    // Gestión Comercial
    Route::get('/almacen', fn () => Inertia::render('Modulos/Almacen'))->name('almacen');
    Route::get('/compras', fn () => Inertia::render('Modulos/Compras'))->name('compras');
    Route::get('/produccion', fn () => Inertia::render('Modulos/Produccion'))->name('produccion');
    Route::get('/ventas', fn () => Inertia::render('Modulos/Ventas'))->name('ventas');
    Route::get('/distribucion', fn () => Inertia::render('Modulos/Distribucion'))->name('distribucion');
    Route::get('/tesoreria', fn () => Inertia::render('Modulos/Tesoreria'))->name('tesoreria');

    // Finanzas
    Route::get('/contabilidad', fn () => Inertia::render('Modulos/Contabilidad'))->name('contabilidad');
    Route::get('/planillas', fn () => Inertia::render('Modulos/Planillas'))->name('planillas');

    // Aplicativos Móviles
    Route::get('/vendedores', fn () => Inertia::render('Modulos/Vendedores'))->name('vendedores');
    Route::get('/repartidores', fn () => Inertia::render('Modulos/Repartidores'))->name('repartidores');
    Route::get('/almaceneros', fn () => Inertia::render('Modulos/Almaceneros'))->name('almaceneros');
    Route::get('/gerentes', fn () => Inertia::render('Modulos/Gerentes'))->name('gerentes');
    Route::get('/supervisor', fn () => Inertia::render('Modulos/Supervisor'))->name('supervisor');
});

Route::get('/contacto', [ContactoController::class, 'create'])
    ->name('contacto.create');

Route::post('/contacto', [ContactoController::class, 'store'])
    ->middleware('throttle:5,1') // 5 envíos por minuto por IP
    ->name('contacto.store');



require __DIR__.'/auth.php';
