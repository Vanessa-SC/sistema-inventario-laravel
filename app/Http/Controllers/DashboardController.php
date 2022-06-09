<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        /* Info de las tarjetas en dashboard */
        $usuarios = count(DB::table('users')->select(['id'])->get());
        $compras = DB::table('entradas')->whereMonth('created_at', now()->month)->sum(DB::raw('precio*cantidad'));
        $invertido = DB::table('entradas')->sum(DB::raw('precio*cantidad'));

        $ventas = DB::table('ventas')->where('created_at', 'like', '%'.now()->format('Y-m-d').'%')->sum('total');
        $apartados = DB::table('apartados')->where('created_at', 'like', '%'.now()->format('Y-m-d').'%')->sum('anticipo');
        $abonos = DB::table('abonos')->where('created_at', 'like', '%'.now()->format('Y-m-d').'%')->sum('monto');
        $ventas += $apartados + $abonos;

        $ventasMes = DB::table('ventas')->where('created_at', 'like', '%'.now()->format('Y-m').'%')->sum('total');
        $apartadosMes = DB::table('apartados')->where('created_at', 'like', '%'.now()->format('Y-m').'%')->sum('anticipo');
        $abonosMes = DB::table('abonos')->where('created_at', 'like', '%'.now()->format('Y-m').'%')->sum('monto');

        $ventasMes += $apartadosMes + $abonosMes;
        $productos = DB::table('products')->count();

        /* Info para las gráficas */

        $data = DB::select( DB::raw("SELECT sum(IFNULL(cantidad,0)) as cantidad
                FROM (
                    SELECT 5 AS hora UNION
                    SELECT 6 AS hora UNION
                    SELECT 7 AS hora UNION
                    SELECT 8 AS hora UNION
                    SELECT 9 AS hora UNION
                    SELECT 10 AS hora UNION
                    SELECT 11 AS hora UNION
                    SELECT 12 AS hora UNION
                    SELECT 13 AS hora UNION
                    SELECT 14 AS hora UNION
                    SELECT 15 AS hora UNION
                    SELECT 16 AS hora UNION
                    SELECT 17 AS hora UNION
                    SELECT 18 AS hora UNION
                    SELECT 19 AS hora UNION
                    SELECT 20 AS hora UNION
                    SELECT 21 AS hora UNION
                    SELECT 22 AS hora UNION
                    SELECT 23 AS hora
                ) listadehoras
                LEFT JOIN salidas
                ON created_at LIKE :fecha
                AND hora = HOUR(created_at)
                GROUP BY hora"), array('fecha' => date('Y-m-d').'%',));
        $lista = "";
        foreach ($data as $d) {
            $lista .= $d->cantidad.',';     
        }
        $productosVendidosPorHora = substr($lista, 0, -1);

        function get_tabla_por_horas($tabla){
            $data = DB::select( DB::raw("SELECT 
                    SUM(IF(HOUR(created_at) = 5,  1, 0)) AS hora5,
                    SUM(IF(HOUR(created_at) = 6,  1, 0)) AS hora6,
                    SUM(IF(HOUR(created_at) = 7,  1, 0)) AS hora7,
                    SUM(IF(HOUR(created_at) = 8,  1, 0)) AS hora8,
                    SUM(IF(HOUR(created_at) = 9,  1, 0)) AS hora9,
                    SUM(IF(HOUR(created_at) = 10,  1, 0)) AS hora10,
                    SUM(IF(HOUR(created_at) = 11,  1, 0)) AS hora11,
                    SUM(IF(HOUR(created_at) = 12,  1, 0)) AS hora12,
                    SUM(IF(HOUR(created_at) = 13,  1, 0)) AS hora13,
                    SUM(IF(HOUR(created_at) = 14,  1, 0)) AS hora14,
                    SUM(IF(HOUR(created_at) = 15,  1, 0)) AS hora15,
                    SUM(IF(HOUR(created_at) = 16,  1, 0)) AS hora16,
                    SUM(IF(HOUR(created_at) = 17,  1, 0)) AS hora17,
                    SUM(IF(HOUR(created_at) = 18,  1, 0)) AS hora18,
                    SUM(IF(HOUR(created_at) = 19,  1, 0)) AS hora19,
                    SUM(IF(HOUR(created_at) = 20,  1, 0)) AS hora20,
                    SUM(IF(HOUR(created_at) = 21,  1, 0)) AS hora21,
                    SUM(IF(HOUR(created_at) = 22,  1, 0)) AS hora22,
                    SUM(IF(HOUR(created_at) = 23,  1, 0)) AS hora23    
                FROM ".$tabla."
                WHERE created_at LIKE :fecha
                "), array('fecha' => date('Y-m-d').'%',));
            $lista = "";
            foreach ($data as $d) {
                foreach ($d as $hora) {
                    $lista .= $hora.',';
                }
            }
            return substr($lista, 0, -1);
        }
        
        $ventasPorHora = get_tabla_por_horas('ventas');
        $apartadosPorHora = get_tabla_por_horas('apartados');
        $abonosPorHora = get_tabla_por_horas('abonos');

        function get_tabla_por_mes($tabla){
            $mes = DB::select(DB::raw("SELECT
                    SUM(IF(MONTH(created_at) = 1,  1, 0)) AS Ene,
                    SUM(IF(MONTH(created_at) = 2,  1, 0)) AS Feb,
                    SUM(IF(MONTH(created_at) = 3,  1, 0)) AS Mar,
                    SUM(IF(MONTH(created_at) = 4,  1, 0)) AS Abr,
                    SUM(IF(MONTH(created_at) = 5,  1, 0)) AS May,
                    SUM(IF(MONTH(created_at) = 6,  1, 0)) AS Jun,
                    SUM(IF(MONTH(created_at) = 7,  1, 0)) AS Jul,
                    SUM(IF(MONTH(created_at) = 8,  1, 0)) AS Ago,
                    SUM(IF(MONTH(created_at) = 9,  1, 0)) AS Sep,
                    SUM(IF(MONTH(created_at) = 10, 1, 0)) AS Oct,
                    SUM(IF(MONTH(created_at) = 11, 1, 0)) AS Nov,
                    SUM(IF(MONTH(created_at) = 12, 1, 0)) AS Dic
                FROM ".$tabla."
                WHERE created_at LIKE '%".now()->year."%';"));
            $lista = "";
            foreach ($mes[0] as $key => $value) {
                    if($key === 'Dic'){
                    $lista .= $value;
                } else {
                    $lista .= $value.',';
                }  
            }
            return $lista;
        }
        
        $ventasPorMes = get_tabla_por_mes('salidas');
        $comprasPorMes = get_tabla_por_mes('entradas');

        return view('sistema.dashboard.index', compact('usuarios','compras','ventas','invertido','productos','productosVendidosPorHora', 'ventasPorHora','abonosPorHora', 'apartadosPorHora', 'ventasMes', 'ventasPorMes', 'comprasPorMes'));

    }
}
