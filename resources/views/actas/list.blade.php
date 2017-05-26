@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Actas <small>Lista de Actas</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Actas
				</li>

			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
            <table class="table table-bordered tabla-hover table-responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numero del Acta</th>
                        <th>Inicio de la reunion</th>
                        <th>Fin de la reunion</th>
                        <th>Elaboro</th>
                        <th>Reviso</th>
                        <th>Aprobo</th>
                        <th>Enviar</th>
                        <th>Imprimir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($acta as $actas)
                        <tr>
                            <td>{{$actas->numeroacta}}</td>
                            <td>{{$actas->fhini}}</td>
                            <td>{{$actas->fhfin}}</td>
                            <td>{{$actas->user_elaboro}}</td>
                            <td>{{$actas->user_reviso}}</td>
                            <td>{{$actas->user_aprobo}}</td>
                            <td><a type="button" class="btn btn-primary" href="{{ URL::route('GET_send_acta',['numeroacta' => $actas->numeroacta]) }}"><i class="glyphicon glyphicon-send"></i> Enviar </a></td>
                            <td><a type="button" class="btn btn-primary" href="{{ URL::route('GET_pdf_acta',['numeroacta' => $actas->numeroacta]) }}"><i class="glyphicon glyphicon-print"></i> Imprimir </a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
		</div>
	</div>
@endsection