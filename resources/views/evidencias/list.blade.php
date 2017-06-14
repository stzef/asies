@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Evidencias <small>Lista de Evidencias</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Evidencias
				</li>

			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
            <table class="table table-bordered tabla-hover table-responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Actividad</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evidencias as $evidencia)
                        <tr>
                            <td>{{$evidencia->nombre}}</td>
                            <td>{{$evidencia->descripcion}}</td>
                            <td>{{$evidencia->actividad->nactividad}}</td>
                            <td>{{$evidencia->fregistro}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
		</div>
	</div>
@endsection
