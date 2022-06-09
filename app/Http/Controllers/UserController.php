<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Models\Activity;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    public function __construct(){
        $this->middleware('can:usuarios.index')->only('index');
        $this->middleware('can:usuarios.edit')->only('edit','store');
        $this->middleware('can:usuarios.create')->only('create','update');
        $this->middleware('can:usuarios.destroy')->only('destroy');
    }
    

    public function index()
    {
        $users = User::paginate();
        return view('sistema.users.index', compact('users'));
    }

    public function create()
    {
        return view('sistema.users.create');
    }


    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'nombre' => $request->nombre,
            'password' => Hash::make($request->password),
        ]);

        if ($request->file('file')) {
            $url = Storage::put('images', $request->file('file'));
            $user->image()->create(['url' => $url]);
        }

        Activity::create([
            'descripcion' => "Creó al usuario $user->nombre",
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('usuarios.edit', $user)->with('info', 'Usuario creado');
        //
    }


    public function edit(User $user)
    {
        return view('sistema.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        if($request->password != ''){
            $user->update([
                'name' => $request->name,
                'nombre' => $request->nombre,
                'password' => Hash::make($request->password),
            ]); 
        } else {
            $user->update($request->all());
        }
        // $this->authorize('author', $user);
        if ($request->file('file')) {
            $url = Storage::put('images', $request->file('file'));
            if ($user->image) {
                Storage::delete($user->image->url);
                $user->image->update(['url' => $url]);
            } else {
                $user->image()->create(['url' => $url]);
            }
        }

        Activity::create([
            'descripcion' => "Modificó al usuario $user->nombre",
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('usuarios.index')->with('info', 'Usuario actualizado');
    }


    public function destroy(User $user)
    {
        if($user->image) {
            Storage::delete($user->image->url);
            $user->image->delete();
        }
        $user->delete();

        Activity::create([
            'descripcion' => "Eliminó al usuario $user->nombre",
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('usuarios.index')->with('info', "Usuario $user->nombre eliminado");
    }

    
}
