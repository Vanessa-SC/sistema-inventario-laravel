@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <h1>Actividad del sistema</h1>
    </div>
    <div class="col-sm-12 col-md-4 text-right">
        <a target="_blank" href="{{route('pdf.log')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-secondary">
                    <tr>
                        <td class="text-center">ID</td>
                        <td>Usuario</td>
                        <td>Actividad</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                    @if(count($activities) == 0)
                    <tr>
                        <td colspan="4" class="p-4 text-center text-secondary"><h5>No hay actividad</h5></td>
                    </tr>
                    @endif
                    @foreach($activities as $activity)
                    <tr>
                        <td class="text-center">{{ $activity->id }}</td>
                        <td>{{ $activity->user->name }}</td>
                        <td>{{ $activity->descripcion }}</td>
                        <td>{{ $activity->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $activities->links() }}
    </div>
</div>
@endsection

