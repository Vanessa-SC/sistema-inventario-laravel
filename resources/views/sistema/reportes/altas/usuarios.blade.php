@extends('layouts.plantilla')
@section('header')
<div class="row">
    <div class="col-sm-12 col-md-7 col-lg-8 text-uppercase">
        <h5>Alta de usuarios</h3>
    </div>
    
    <div class="col-sm-12 col-ms-5 col-lg-4 text-right float-right ">
        <a target="_blank" href="{{route('pdf.altas-usuarios')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-secondary">
                    <tr>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Username</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td width="160">{{ $usuario->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection