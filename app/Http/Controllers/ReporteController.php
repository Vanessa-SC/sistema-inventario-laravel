<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Entradas;
use App\Models\Venta;
use App\Models\Negocio;
use App\Models\Category;
use App\Models\Proveedore;
use App\Models\Apartado;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ReporteController extends Controller
{
    public function log(){
        $activities = Activity::latest('id')->paginate();
        return view('sistema.reportes.log', compact('activities'));
    }

    public function productos() {
        $entradas = Entradas::latest('id')->paginate();
        return view('sistema.reportes.altas.productos', compact('entradas'));
    }

    public function categorias() {
        $categories = Category::latest('id')->paginate();
        return view('sistema.reportes.altas.categorias', compact('categories'));
    }

    public function proveedores() {
        $proveedores = Proveedore::latest('id')->paginate();
        return view('sistema.reportes.altas.proveedores', compact('proveedores'));
    }

    public function usuarios() {
        $usuarios = User::latest('id')->paginate();
        return view('sistema.reportes.altas.usuarios', compact('usuarios'));
    }

    public function ticketV(Venta $venta){
        $negocio = Negocio::find(1);
        return view('sistema.venta.ticket', compact('venta','negocio'));
    }

    public function ticketA(Apartado $apartado){
        $negocio = Negocio::find(1);
        return view('sistema.apartado.ticket', compact('apartado','negocio'));
    }

    public function ticketAb(Abono $abono){
        $negocio = Negocio::find(1);
        return view('sistema.apartado.ticket-abono', compact('abono','negocio'));
    }

    public function ventas(){
        $usuarios = User::all();
        $ventas = Venta::latest('id')->paginate();
        foreach ($ventas as $venta) {
            $cantidad = 0;
            foreach ($venta->productos as $producto) {
                $cantidad += $producto['pivot']['cantidad'];
                $venta['cantidad'] = $cantidad;
            }
           // $venta['cantidad'] = $v
        }
        $filtro = '';
        return view('sistema.reportes.ventas.index', compact('ventas','usuarios', 'filtro'));
    }

    public function ventasFiltro(Request $request){
        $usuarios = User::all();
        if ($request->filtro == 'fecha'){
            $ventas = Venta::whereBetween('created_at', [$request->fecha_inicio.' 00:00:00', $request->fecha_fin.' 23:59:59'])->paginate();
        } else if ($request->filtro == 'usuario'){
            
            $ventas = Venta::where('user_id', +$request->usuario)->latest('id')->paginate();
        } else {
            $ventas = Venta::latest('id')->paginate();
        }
        foreach ($ventas as $venta) {
            $cantidad = 0;
            foreach ($venta->productos as $producto) {
                $cantidad += $producto['pivot']['cantidad'];
                $venta['cantidad'] = $cantidad;
            }
        }
        $filtro = $request->filtro;
        return view('sistema.reportes.ventas.index', compact('ventas','usuarios','filtro'));
    }

    public function apartados(){
        $usuarios = User::all();
        $clientes = Apartado::select('cliente')->distinct()->get();
        $apartados = Apartado::latest('id')->paginate();
        foreach ($apartados as $apartado) {
            $cantidad = 0;
            foreach ($apartado->productos as $producto) {
                $cantidad += $producto['pivot']['cantidad'];
                $apartado['cantidad'] = $cantidad;
            }
           // $venta['cantidad'] = $v
        }
        $filtro = '';

        return view('sistema.reportes.apartados.index', compact('apartados', 'filtro', 'usuarios','clientes'));
    }

    public function apartadosFiltro(Request $request, Builder $query){
        $usuarios = User::all();
        $clientes = Apartado::select('cliente')->distinct()->get();
        if ($request->filtro == 'fecha'){
            $apartados = Apartado::whereBetween('created_at', [$request->fecha_inicio.' 00:00:00', $request->fecha_fin.' 23:59:59'])->paginate();
        } else if ($request->filtro == 'usuario'){
            $ab = Abono::where('user_id', $request->usuario)->get();
            $ap = Apartado::where('user_id', +$request->usuario)->get();
            $abonos = array();
            foreach ($ab as $abono) {
                $abonos[] = $abono->apartado;
            }
            $pre = $ap->concat($abonos);
            $apartados = $pre->unique()->sortBy('id');
        } else if ($request->filtro == 'cliente'){
            $apartados = Apartado::where('cliente', $request->cliente)->latest('cliente')->paginate();
        } else {
            $apartados = Apartado::latest('id')->paginate();
        }
        $filtro = $request->filtro;
        return view('sistema.reportes.apartados.index', compact('apartados','usuarios','filtro','clientes'));
    }

   
}
