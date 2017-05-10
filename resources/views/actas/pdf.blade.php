@extends('layouts.pdf')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('layout/css/bootstrap-without-icons.min.css') }}" >

@endsection


@section('header')
	<img src="{{ URL::asset('img/logo.png') }}" alt="" width="10%">
@endsection

@section('body')
<h3 class="text-center">Acta Numero {{ $acta->numeroacta }}</h3>
<table class="table">

	<tr>
		<td> Objetivos : </td>
		<td>{{ $acta->objetivos }} </td>
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



<table class="text-center" width="100%">
	<tr>
		<td>________________________</td>
		<td>________________________</td>
		<td>________________________</td>
	</tr>
	<tr>
		<td>Elaboro</td>
		<td>Reviso</td>
		<td>Aprobo</td>
	</tr>
</table>
@endsection

@section('footer')
@endsection

@section('scripts')
@endsection
