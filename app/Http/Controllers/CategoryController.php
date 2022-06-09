<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Activity;

class CategoryController extends Controller
{

    public function __construct(){
        $this->middleware('can:categories.index')->only('index');
        $this->middleware('can:categories.edit')->only('edit','store');
        $this->middleware('can:categories.create')->only('create','update');
        $this->middleware('can:categories.destroy')->only('destroy');
    }


    public function index()
    {
        $categories = Category::all();
        return view('sistema.categories.index', compact('categories'));
    }

    
    public function create()
    {
        return view('sistema.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $category = Category::create($request->all());
        Activity::create([
            'user_id' => auth()->user()->id,
            'descripcion' => "Creó la categoría $category->nombre"
        ]);

        return redirect()->route('categories.edit',$category)->with('info', 'Categoría creada');
    }

    public function edit(Category $category)
    {
        return view('sistema.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $nombre = $category->nombre;

        $category->update($request->all());
        Activity::create([
            'user_id' => auth()->user()->id,
            'descripcion' => 'Cambió el nombre de la categoría '.$nombre.' a '.$category->nombre
        ]);

        return redirect()->route('categories.edit',$category)->with('info', 'Categoría actualizada');
    }

    public function destroy(Category $category)
    {
        Activity::create([
            'user_id' => auth()->user()->id,
            'descripcion' => "Eliminó la categoría $category->nombre"
        ]);
        $category->delete();
        return redirect()->route('categories.index')->with('info', 'Categoría eliminada');
    }
}
