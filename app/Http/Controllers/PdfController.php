<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Product;
use App\Models\Category;
use App\Models\Proveedore;
use App\Models\Venta;
use App\Models\Apartado;
use App\Models\Entradas;
use App\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;


class PdfController extends Controller
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdf;
    }

    public function log(){ 
        $activities = Activity::all();
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, 'Actividad del sistema');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(10,7,'ID',1, 0, 'C', true);
        $pdf->Cell(35,7,'Usuario',1, 0, 'L', true);
        $pdf->Cell(110,7,'Descripcion',1, 0, 'L', true);
        $pdf->Cell(35,7,'Fecha',1, 0, 'L', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        foreach ($activities as $activity) {
            $pdf->Cell(10,7, $activity->id, 'LR', 0, 'C');
            $pdf->Cell(35,7,utf8_decode($activity->user->name),'LR');
            $pdf->Cell(110,7,utf8_decode($activity->descripcion),'LR');
            $pdf->Cell(35,7,$activity->created_at,'LR');
            $pdf->Ln();
        }
        $pdf->Cell(190,0,'','T');
        $pdf->Output('I','Actividad.pdf');
        exit;
    }

    public function inventario(){ 
        $productos = Product::orderBy('descripcion', 'asc')->get();
        $pdf = new Fpdf();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, 'Inventario');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(275, 7, 'I = Stock inicial, A = Stock actual, E = Entradas, S = Salidas', 0,0,'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(28,7,'Codigo',1, 0, 'C', true);
        $pdf->Cell(85,7,'Descripcion',1, 0, 'L', true);
        $pdf->Cell(20,7,'Precio',1, 0, 'C', true);
        $pdf->Cell(20,7,'Precio P.',1, 0, 'C', true);
        $pdf->Cell(30,7,'Proveedor',1, 0, 'C', true);
        $pdf->Cell(20,7,'Categoria',1, 0, 'C', true);
        
        $pdf->Cell(12,7,'I',1, 0, 'C', true);
        $pdf->Cell(12,7,'A',1, 0, 'C', true);
        $pdf->Cell(12,7,'E',1, 0, 'C', true);
        $pdf->Cell(12,7,'S',1, 0, 'C', true);

        $pdf->Cell(26,7,'Registro',1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        foreach ($productos as $producto) {
            $pdf->Cell(28,7, $producto->codigo, 'LR', 0, 'C');
            $pdf->Cell(85,7,utf8_decode($producto->descripcion),'LR');
            $pdf->Cell(20,7, '$ '.number_format($producto->precio_publico,2), 'LR', 0, 'R');
            $pdf->Cell(20,7, '$ '.number_format($producto->precio_proveedor,2), 'LR', 0, 'R');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(30,7, utf8_decode($producto->proveedor->nombre ?? ''), 'LR', 0, 'L');
            $pdf->Cell(20,7, utf8_decode($producto->categoria->nombre ?? ''), 'LR', 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(12,7,$producto->stock_inicial,'LR', 0, 'C');
            $pdf->Cell(12,7,$producto->existencias,'LR', 0, 'C');
            $pdf->Cell(12,7,$producto->entradas()->sum('cantidad'),'LR', 0, 'C');
            $pdf->Cell(12,7,$producto->salidas()->sum('cantidad'),'LR', 0, 'C');
            $pdf->Cell(26,7, $producto->created_at->format('d-m-y H:i'), 'LR', 0, 'C');
            $pdf->Ln();
        }
        $pdf->Cell(277,0,'','T');
        $pdf->Output('I','Inventario.pdf');
        exit;
    }

    public function categorias(){ 
        $categorias = Proveedore::all();
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, utf8_decode('Categorías'));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(10,7,'ID',1, 0, 'C', true);
        $pdf->Cell(145,7,'Nombre',1, 0, 'L', true);
        $pdf->Cell(35,7,'Registrado',1, 0, 'L', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        foreach ($categorias as $proveedore) {
            $pdf->Cell(10,7, $proveedore->id, 'LR', 0, 'C');
            $pdf->Cell(145,7,utf8_decode($proveedore->nombre),'LR');
            $pdf->Cell(35,7,$proveedore->created_at,'LR');
            $pdf->Ln();
        }
        $pdf->Cell(190,0,'','T');
        $pdf->Output('I','Proveedores.pdf');
        exit;
    }

    public function proveedores(){ 
        $proveedores = Proveedore::all();
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, utf8_decode('Proveedores'));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(10,7,'ID',1, 0, 'C', true);
        $pdf->Cell(45,7,'Nombre',1, 0, 'L', true);
        $pdf->Cell(105,7,'Contacto',1, 0, 'L', true);
        $pdf->Cell(30,7,'Registrado',1, 0, 'L', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        foreach ($proveedores as $proveedor) {
            $pdf->Cell(10,7, $proveedor->id, 'LR', 0, 'C');
            $pdf->Cell(45,7,utf8_decode($proveedor->nombre),'LR');
            $pdf->Cell(105,7,utf8_decode($proveedor->email.', telefono: '.$proveedor->telefono),'LR');
            $pdf->Cell(30,7,$proveedor->created_at->format('d-m-Y H:i'),'LR');
            $pdf->Ln();
        }
        $pdf->Cell(190,0,'','T');
        $pdf->Output('I','Proveedor.pdf');
        exit;
    }

    public function ventas(){
        $ventas = Venta::all();
        
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, utf8_decode('Ventas'));
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Ln();
        $pdf->Cell(190,7,utf8_decode('P = Número de productos vendidos'),0, 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(30,7,'Folio',1, 0, 'C', true);
        $pdf->Cell(15,7,'P',1, 0, 'C', true);
        $pdf->Cell(25,7,'Total',1, 0, 'C', true);
        $pdf->Cell(45,7,'Cliente',1, 0, 'C', true);
        $pdf->Cell(45,7,'Vendedor',1, 0, 'C', true);
        $pdf->Cell(30,7,'Fecha',1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);

        foreach ($ventas as $venta) {
            $cantidad = 0;
            foreach ($venta->productos as $producto) {
                $cantidad += $producto['pivot']['cantidad'];
            }
            $pdf->Cell(30,7,$venta['folio'],1, 0, 'L');
            $pdf->Cell(15,7,$cantidad,1, 0, 'C');
            $pdf->Cell(25,7,'$'.number_format($venta['total'],2),1, 0, 'R');
            $pdf->Cell(45,7,$venta['cliente'],1, 0, 'L');
            $pdf->Cell(45,7,$venta['user']['nombre'],1, 0, 'L');
            $pdf->Cell(30,7,$venta['created_at']->format('d-m-Y H:i'),1, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Output('I','Ventas.pdf');
        exit; 
    }

    public function altasUsuarios(){
        $users = User::all();
        
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, utf8_decode('Alta de usuarios'));
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Ln();
        // $pdf->Cell(190,7,utf8_decode('P = Número de productos vendidos'),0, 0, 'R');
        // $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(15,7,'ID',1, 0, 'C', true);
        $pdf->Cell(85,7,'Nombre',1, 0, 'C', true);
        $pdf->Cell(60,7,'Username',1, 0, 'C', true);
        $pdf->Cell(30,7,'Fecha',1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);

        foreach ($users as $user) {
            $pdf->Cell(15,7,$user['id'],1, 0, 'C');
            $pdf->Cell(85,7,$user['nombre'],1, 0, 'L');
            $pdf->Cell(60,7,$user['name'],1, 0, 'L');
            $pdf->Cell(30,7,$user['created_at']->format('d-m-Y H:i'),1, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Output('I','Altas de usuarios.pdf');
        exit; 
    }

    public function altasProductos(){
        $entradas = Entradas::latest('id')->get();
        
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, utf8_decode('Altas de producto'));
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Ln();
       $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(32,7,utf8_decode('Código'),1, 0, 'C', true);
        $pdf->Cell(88,7,'Descripcion',1, 0, 'C', true);
        $pdf->Cell(18,7,'Cant',1, 0, 'C', true);
        $pdf->Cell(20,7,'Precio',1, 0, 'C', true);
        $pdf->Cell(32,7,'Fecha',1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);

        foreach ($entradas as $entrada) {
            $pdf->Cell(32,7,$entrada['producto']['codigo'],1, 0, 'C');
            $pdf->Cell(88,7,utf8_decode($entrada['producto']['descripcion']),1, 0, 'L');
            $pdf->Cell(18,7,$entrada['cantidad'],1, 0, 'C');
            $pdf->Cell(20,7,'$'.number_format($entrada['precio'],2),1, 0, 'R');
            $pdf->Cell(32,7,$entrada['created_at']->format('d-m-Y H:i'),1, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Output('I','Altas de usuarios.pdf');
        exit; 
    }

    public function apartados(){
        $ventas = Apartado::all();
        
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, utf8_decode('Ventas'));
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Ln();
        $pdf->Cell(190,7,utf8_decode('P = Número de productos vendidos'),0, 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetFillColor(142, 146, 148);
        $pdf->SetTextColor(255);
        $pdf->setDrawColor(142, 146, 148);

        $pdf->Cell(30,7,'Folio',1, 0, 'C', true);
        $pdf->Cell(15,7,'P',1, 0, 'C', true);
        $pdf->Cell(25,7,'Total',1, 0, 'C', true);
        $pdf->Cell(45,7,'Cliente',1, 0, 'C', true);
        $pdf->Cell(45,7,'Vendedor',1, 0, 'C', true);
        $pdf->Cell(30,7,'Fecha',1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);

        foreach ($ventas as $venta) {
            $cantidad = 0;
            foreach ($venta->productos as $producto) {
                $cantidad += $producto['pivot']['cantidad'];
            }
            $pdf->Cell(30,7,$venta['folio'],1, 0, 'L');
            $pdf->Cell(15,7,$cantidad,1, 0, 'C');
            $pdf->Cell(25,7,'$'.number_format($venta['total'],2),1, 0, 'R');
            $pdf->Cell(45,7,$venta['cliente'],1, 0, 'L');
            $pdf->Cell(45,7,$venta['user']['nombre'],1, 0, 'L');
            $pdf->Cell(30,7,$venta['created_at']->format('d-m-Y H:i'),1, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Output('I','Ventas.pdf');
        exit; 
    }

}
