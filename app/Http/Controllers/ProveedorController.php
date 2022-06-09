<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Proveedore;

class ProveedorController extends Controller
{
    public function __construct(){
        $this->middleware('can:proveedores.index')->only('index');
        $this->middleware('can:proveedores.edit')->only('edit','store');
        $this->middleware('can:proveedores.create')->only('create','update');
        $this->middleware('can:proveedores.destroy')->only('destroy');
    }

    public function index()
    {
        $proveedores = Proveedore::all();
        return view('sistema.proveedores.index', compact('proveedores'));
    }

    
    public function create()
    {
        return view('sistema.proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $proveedore = Proveedore::create($request->all());
        Activity::create([
            'user_id' => auth()->user()->id,
            'descripcion' => "Creó el proveedor $proveedore->nombre"
        ]);

        return redirect()->route('proveedores.edit',$proveedore)->with('info', 'Proveedor registrado');
    }

    public function edit(proveedore $proveedore)
    {
        return view('sistema.proveedores.edit', compact('proveedore'));
    }

    public function update(Request $request, proveedore $proveedore)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $nombre = $proveedore->nombre;

        $proveedore->update($request->all());
        Activity::create([
            'user_id' => auth()->user()->id,
            'descripcion' => 'Modificó al proveedor '.$proveedore->nombre
        ]);

        return redirect()->route('proveedores.edit',$proveedore)->with('info', 'Proveedor actualizado');
    }

    public function destroy(proveedore $proveedore)
    {
        Activity::create([
            'user_id' => auth()->user()->id,
            'descripcion' => "Eliminó al proveedor $proveedore->nombre"
        ]);
        $proveedore->delete();
        return redirect()->route('proveedores.index')->with('info', 'Proveedor eliminado');
    }
}
