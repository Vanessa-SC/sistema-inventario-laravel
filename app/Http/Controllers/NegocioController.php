<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\Activity;

use Illuminate\Support\Facades\Storage;

class NegocioController extends Controller
{

    public function __construct(){
        $this->middleware('can:negocio.edit')->only('index');
    }

    public function index (){
        $negocio = Negocio::find(1);
        return view('sistema.negocio.index', compact('negocio'));
    }

    public function update(Request $request, Negocio $id ){
        $negocio = Negocio::find(1);
        $negocio->update($request->all());

        if ($request->file('file')) {
            $url = Storage::put('images', $request->file('file'));
            if ($negocio->image) {
                Storage::delete($negocio->image->url);
                $negocio->image->update(['url' => $url]);
            } else {
                $negocio->image()->create(['url' => $url]);
            }
        }

        Activity::create([
            'descripcion' => "Modificó los datos del negocio",
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('negocio.index')->with('info', 'Datos actualizados correctamente');
    }
}
