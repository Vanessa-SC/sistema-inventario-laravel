<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesPermisosController extends Controller
{
    public function index(){
        $roles = Role::all();
        $permisos = \Spatie\Permission\Models\Permission::all();
        return view('sistema.roles-permisos.index', compact('roles', 'permisos'));
    }
}
