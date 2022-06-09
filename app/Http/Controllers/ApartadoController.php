<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Apartado;
use App\Models\Abono;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Salidas;

class ApartadoController extends Controller
{
    public function __construct(){
        $this->middleware('can:apartado.index')->only('index','store');
        $this->middleware('can:apartado.destroy')->only('destroy');
    }

    public function index()
    {
        $productos = Product::where('existencias', '>=', '1')->get()->pluck('descripcion', 'codigo');
        $productos->prepend('Seleccionar producto', '0');
        
        return view('sistema.apartado.index', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto' => 'not_in:0',
            'cliente' => 'required',
            'anticipo' => 'required|numeric'
        ]);

        try {
            $transaction = DB::transaction(function () use ($request) {
                $producto = Product::where('codigo',$request->producto)->first();
                $numeroApartados = DB::select(DB::raw("SELECT max(id) as n_apartados FROM apartados"));
                $num = $numeroApartados[0]->n_apartados;
                $folio = 'A'.str_pad($num+1, 12, "0", STR_PAD_LEFT);
                $apartado = Apartado::create([
                    'folio' => $folio,
                    'cliente' => $request->cliente,
                    'anticipo' => $request->anticipo,
                    'monto_abonado' => $request->anticipo,
                    'fecha_limite' => $request->limite.' 23:59:59',
                    'estado' => 'Pendiente',
                    'user_id' => auth()->user()->id
                ]);

                Salidas::create([
                    'cantidad'   => 1,
                    'precio'     => $producto['precio_publico'],
                    'product_id' => $producto['id']
                ]);
                $producto->update(['existencias' => $producto['existencias']-1]);
                
                $apartado->productos()->attach($producto->id, array('precio' => $producto->precio_publico));
            
                Activity::create([
                    'descripcion' => "Realizó el apartado con el folio $folio",
                    'user_id' => auth()->user()->id
                ]);
                return $apartado->id;
            });

            return redirect()->route('apartado')
                    ->with('success', 'Apartado realizado con éxito')
                    ->with('id', $transaction);
            
        } catch (\Exception $e){
            return redirect()->route('apartado')
                    ->with('error', 'Ocurrió un error al realizar el apartado')
                    ->with('mensaje', $e->getMessage());
        }
    }

    public function buscar(Apartado $apartado){
        $producto = $apartado->productos->first();
        return response()->json([
            'producto' => $producto,
            'apartado' => $apartado
        ]);
    }

    public function abono(){
        $apartados = Apartado::where('estado', 'Pendiente')->get();
        return view('sistema.apartado.abono', compact('apartados'));
    }

    public function storeAbono(Apartado $apartado, Request $request){
        try {
            $transaction = DB::transaction(function () use ($request,$apartado) {
                $abono = Abono::create([
                    'apartado_id' => $apartado->id,
                    'monto' => $request->monto,
                    'user_id' => auth()->user()->id
                ]);
                $apartado->monto_abonado += $request->monto;
                $apartado->save();

                Activity::create([
                    'descripcion' => "Realizó un abono al apartado con el folio $apartado->folio",
                    'user_id' => auth()->user()->id
                ]);
                    
                if($abono->monto + $apartado->monto_abonado >= $apartado->productos->first()->pivot->precio){
                    $apartado->estado = 'Liquidado';
                    $apartado->save();
                }

                return $abono->id;
            });

            return response()->json([
                'success' => true,
                'id' => $transaction
            ]);
            
        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
}
