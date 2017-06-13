@extends('layouts.pdf')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('layout/css/bootstrap-without-icons.min.css') }}" >

@endsection


@section('header')
	<div class="text-center" style="min-height:100px; ">
		<img  src="{{ URL::asset('img/alcaldias/guataqui/banner.png') }}" alt="" width="450px">
		<!--<img  src="{{ URL::asset('img/alcaldias/'.env('SLUG_APP').'/banner.png') }}" alt="" width="450px">-->
	</div>
@endsection

@section('footer')
	<div class="text-center">
		<span>“Buen gobierno con transparencia responsabilidad y compromiso social 2016-2019</span><br>
		<span>NIT.800011271-9</span><br>
		<span>CODIGO POSTAL 252820</span>
	</div>
@endsection

@section('body')
	<h3 class="text-center">Acta Numero {{ $acta->numeroacta }}</h3>
	<table class="table">

		<tr>
			<td> Objetivos : </td>
			<td>{!! $acta->objetivos !!} </td>
		</tr>
		<tr>
			<td> Fecha Inicial : </td>
			<td>{{ $acta->fhini }} </td>
		</tr>
		<tr>
			<td> Fecha Final : </td>
			<td>{{ $acta->fhfin }} </td>
		</tr>
	</table>

	<h2> Asistentes </h2>
	<table class="table">
		@foreach( $acta->asistentes as $asistente )
		<tr>
			<td> {{ $asistente->usuario->persona->nombreCompleto() }} </td>
		</tr>
		@endforeach
	</table>

	<h2> Tareas </h2>
	<table class="table">
		<tr>
			<td> Tarea </td>
			<td> Realizada </td>
		</tr>
		@foreach( $actividad->getTareas() as $tarea )
		<tr>
			<td> {{ $tarea->ntarea }} </td>
			<td> @if($tarea->ifhecha) Si @else No @endif </td>
		</tr>
		@endforeach

	</table>

	<p>{{ $acta->sefirma }}</p>
	<table class="text-center" width="100%">
		<tr>
			<td>________________________</td>
			<td>________________________</td>
			<td>________________________</td>
		</tr>
		<tr>
			<td>{{ $acta->elaboro->persona->nombreCompleto() }}</td>
			<td>{{ $acta->reviso->persona->nombreCompleto() }}</td>
			<td>{{ $acta->aprobo->persona->nombreCompleto() }}</td>
		</tr>
		<tr>
			<td>Elaboró</td>
			<td>Revisó</td>
			<td>Aproboó</td>
		</tr>
	</table>
@endsection



@section('scripts')
@endsection
