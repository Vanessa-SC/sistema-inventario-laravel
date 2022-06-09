<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

use App\Models\Product;
use App\Models\Category;
use App\Models\Proveedore;
use App\Models\Activity;
use App\Models\Entradas;
use App\Models\Salidas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    
    public function __construct(){
        $this->middleware('can:productos.index')->only('index');
        $this->middleware('can:productos.edit')->only('edit','store');
        $this->middleware('can:productos.create')->only('create','update');
        $this->middleware('can:productos.destroy')->only('destroy');
    }

    public function index()
    {
        return view('sistema.products.index');
    }

    
    public function create()
    {
        $editando = false;
        $categorias = Category::pluck('nombre', 'id');
        $proveedores = Proveedore::pluck('nombre', 'id');
        return view('sistema.products.create', compact('categorias','proveedores','editando'));
    }
    
    public function store(ProductRequest $request)
    {
        //dd($request);
        $transaction = DB::transaction(function() use ($request){
            $producto = Product::create([
                'codigo' => $request->codigo,
                'folio' => $request->folio,
                'descripcion' => $request->descripcion,
                'stock_inicial' => $request->stock_inicial,
                'existencias' => $request->stock_inicial,
                'precio_publico' => $request->precio_publico,
                'precio_proveedor' => $request->precio_proveedor,
                'marca' => $request->marca,
                'proveedore_id' => $request->proveedore_id,
                'category_id' => $request->category_id,
            ]);
            $producto->categoria()->associate($request->category_id)->save();
            $producto->proveedor()->associate($request->proveedore_id)->save();
            Activity::create([
                'descripcion' => "Agregó el producto $producto->codigo - $producto->descripcion",
                'user_id' => auth()->user()->id
            ]);

            if ($request->file('file')) {
                $url = Storage::put('images', $request->file('file'));
                $producto->image()->create(['url' => $url]);
            }
    
            Entradas::create([
                'cantidad'   => $request->stock_inicial,
                'precio'     => $request->precio_proveedor,
                'product_id' => $producto->id
            ]);
            return $producto->id;
        });

      

        if($transaction){
            return redirect()->route('productos.index')->with('info', 'Producto agregado correctamente');
        }
    }
    
    public function edit(Product $producto)
    {
        $editando = true;
        $categorias = Category::pluck('nombre', 'id');
        $proveedores = Proveedore::pluck('nombre', 'id');
        return view('sistema.products.edit', compact('producto','categorias','proveedores','editando'));
    }
    
    public function update(Request $request, Product $producto)
    {
        
        $producto->update([
            'codigo' => $request->codigo,
            'folio' => $request->folio,
            'descripcion' => $request->descripcion,
            'precio_publico' => $request->precio_publico,
            'precio_proveedor' => $request->precio_proveedor,
            'marca' => $request->marca,
            'proveedore_id' => $request->proveedore_id,
            'category_id' => $request->category_id,
        ]);

        if ($request->file('file')) {
            $url = Storage::put('images', $request->file('file'));
            if ($producto->image) {
                Storage::delete($producto->image->url);
                $producto->image->update(['url' => $url]);
            } else {
                $producto->image()->create(['url' => $url]);
            }
        }

        if($request->add_stock > 0){
            $prod = Product::find($producto->id);
            $prod->existencias += $request->add_stock;
            $prod->save();

            Entradas::create([
                'cantidad'   => $request->add_stock,
                'precio'     => $request->precio_proveedor,
                'product_id' => $producto->id
            ]);
        }

        Activity::create([
            'descripcion' => "Modificó el producto $producto->descripcion ($producto->codigo)",
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('productos.index', $producto)->with('info', 'Producto actualizado');  /**/
    }

  
    public function destroy(Product $producto)
    {
        //
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
