<?php


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ApartadoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RolesPermisosController;

Route::middleware('auth')->resource('categorias', CategoryController::class)->except(['show'])->parameters(['categoria' => 'category'])->names('categories');
Route::middleware('auth')->resource('proveedores', ProveedorController::class)->except(['show'])->names('proveedores');
Route::middleware('auth')->resource('productos', ProductoController::class)->except(['show'])->parameters(['producto' => 'product'])->names('productos');
Route::middleware('auth')->resource('usuarios', UserController::class)->except(['show'])->parameters(['usuarios' => 'user'])->names('usuarios');


Route::middleware('auth')->controller(VentaController::class)->group(function (){
    Route::get('venta', 'index')->name('venta');
    Route::post('venta/crear', 'store')->name('venta.store');
    Route::get('buscar/{producto}', 'buscar')->name('buscar.producto');
    Route::get('venta/productos', 'listaProductos')->name('lista.productos');
});

Route::middleware('auth')->controller(ApartadoController::class)->group(function (){
    Route::get('apartado', 'index')->name('apartado');
    Route::post('apartado/crear', 'store')->name('apartado.store');
    Route::get('buscar/apartado/{apartado}', 'buscar')->name('apartado.buscar');
    Route::get('abonar', 'abono')->name('apartado.abono');
    Route::post('abonar/{apartado}', 'storeAbono')->name('apartado.storeAbono');
});

Route::middleware('auth')->controller(ReporteController::class)->group(function (){
    Route::get('reporte', '')->name('reporte');
    Route::get('reporte/altas/productos', 'productos')->name('reporte.productos');
    Route::get('reporte/altas/categorias', 'categorias')->name('reporte.categorias');
    Route::get('reporte/altas/proveedores', 'proveedores')->name('reporte.proveedores');
    Route::get('reporte/altas/usuarios', 'usuarios')->name('reporte.usuarios');
    Route::get('log', 'log')->name('log');
    Route::get('ticket/{venta}', 'ticketV')->name('ticket.venta');
    Route::get('ticket/apartado/{apartado}', 'ticketA')->name('ticket.apartado');
    Route::get('ticket/abono/{abono}', 'ticketAb')->name('ticket.abono');

    Route::get('reporte/ventas', 'ventas')->name('reporte.ventas');
    Route::post('reporte/ventas', 'ventasFiltro')->name('reporte.ventas-filtro');
    
    Route::get('reporte/apartados', 'apartados')->name('reporte.apartados');
    Route::post('reporte/apartados', 'apartadosFiltro')->name('reporte.apartados-filtro');
});

Route::controller(PdfController::class)->group(function (){
    Route::get('pdf/log', 'log')->name('pdf.log');
    Route::get('pdf/categorias', 'categorias')->name('pdf.categorias');
    Route::get('pdf/proveedores', 'proveedores')->name('pdf.proveedores');
    Route::get('pdf/inventario', 'inventario')->name('pdf.inventario');
    Route::get('pdf/ventas/', 'ventas')->name('pdf.ventas');
    Route::get('pdf/apartados/', 'apartados')->name('pdf.apartados');
    Route::get('pdf/atlas/usuarios', 'altasUsuarios')->name('pdf.altas-usuarios');
    Route::get('pdf/atlas/productos', 'altasProductos')->name('pdf.altas-productos');
});

Route::middleware('auth')->controller(NegocioController::class)->group(function () {
    Route::get('negocio', 'index')->name('negocio.index');
    Route::put('negocio', 'update')->name('negocio.update');
});

Route::middleware('auth')->resource('roles', RolesPermisosController::class);

Route::get('/pwd', function() {
    return view('sistema/users/partials/pwd');
});