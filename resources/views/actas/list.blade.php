@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
@endsection
@section('content')

	<div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Listado de Actas
                </div>
                <div class="panel-body">
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
                                @foreach ($actas as $acta)
                                    <tr>
                                        <td>{{$acta->numeroacta}}</td>
                                        <td>{{$acta->fhini}}</td>
                                        <td>{{$acta->fhfin}}</td>
                                        <td>{{$acta->elaboro->persona->nombreCompleto()}}</td>
                                        <td>{{$acta->reviso->persona->nombreCompleto()}}</td>
                                        <td>{{$acta->aprobo->persona->nombreCompleto()}}</td>
                                        <td><a type="button" class="btn btn-primary" href="{{ URL::route('GET_send_acta',['numeroacta' => $acta->numeroacta]) }}"><i class="glyphicon glyphicon-send"></i> Enviar </a></td>
                                        <td><a type="button" class="btn btn-primary" href="{{ URL::route('GET_pdf_acta',['numeroacta' => $acta->numeroacta]) }}"><i class="glyphicon glyphicon-print"></i> Imprimir </a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            		</div>
                </div>
            </div>
	</div>
@endsection
