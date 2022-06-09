@extends('layouts.plantilla')

@section('header')
<h3>Roles</h3>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-right">
            <button class="btn btn-secondary text-uppercase">Agregar nuevo rol</button>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th colspan="2">Acciones</th>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td><span class="pl-4">{{ $role->name }}</span></td>
                        <td width="30">
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td width="30"> 
                            <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    </li>
                    @endforeach
                </tbody>
            </table>

        </ul>
    </div>
</div>
@endsection