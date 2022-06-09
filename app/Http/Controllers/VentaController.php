<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Venta;
use App\Models\Salidas;
use App\Models\Activity;
use Hamcrest\Type\IsNumeric;

class VentaController extends Controller
{
    public function __construct(){
        $this->middleware('can:venta.index')->only('index','store');
        $this->middleware('can:venta.destroy')->only('destroy');
    }

    public function index(){
        $productos = Product::select(DB::raw('concat_ws(" - ", codigo, descripcion) as descripcion'), 'codigo')->where('existencias','>=', 1)->pluck('descripcion', 'codigo');
        $productos->prepend('Buscar producto', '0');
      
        return view('sistema.venta.index', compact('productos'));
    }

    public function store(Request $request){
        try{   
            $transaction = DB::transaction(function() use ($request){
                $numeroVentas = DB::select(DB::raw("SELECT max(id) as n_ventas FROM ventas"));
                $num = $numeroVentas[0]->n_ventas;
                $folio = 'V'.str_pad($num+1, 12, "0", STR_PAD_LEFT);
                $venta = Venta::create([
                    'folio' => $folio,
                    'cliente' => $request->cliente ?? 'General',
                    'total'   => $request->total,
                    'user_id' => auth()->user()->id
                    ]);
                    
                foreach ($request->productos as $producto) {
                    Salidas::create([
                        'cantidad'   => $producto['cantidad'],
                        'precio'     => $producto['precio_publico'],
                        'product_id' => $producto['id']
                    ]);
                    $prod = Product::find($producto['id']);
                    $prod->update(['existencias' => $prod['existencias']-$producto['cantidad']]);
                        
                    $venta->productos()->attach($producto['id'], array('precio' => $producto['precio_publico'], 'cantidad' => $producto['cantidad']));
                    
                }
                Activity::create([
                    'descripcion' => "Realizó la venta con el folio $folio",
                    'user_id' => auth()->user()->id
                ]);
                return $venta->id;
            });
            return response()->json([
                'status'  => 200,
                'id' => $transaction
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status'  => 500,
                'message' => $e
            ]);
        }
    }

    public function buscar($codigo){
        $producto = Product::where('codigo', $codigo)->first();
        if($producto){
            return response()->json([
                'status' => 200,
                'message'=> 'ok',
                'producto' => $producto
            ]);
        } else {
            return response()->json([
                'status' => 204,
                'message'=> 'No hay productos con ese código'
            ]);
        }
    }

    public function listaProductos(){
        $productos = Product::select(DB::raw('concat_ws(" - ", codigo, descripcion) as descripcion'), 'codigo')->pluck('descripcion', 'codigo');
        $productos->prepend(0, '0');
        return $productos;

    }
}
