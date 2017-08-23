@extends('layouts.app')

@section('styles')
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Evidencias
				@if ( $actividad )
					de la Actividad {{ $actividad->nactividad }}
				@endif
				<small>Lista de Evidencias</small>
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
            <table class="evidencias table table-bordered tabla-hover table-responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        @if ( !$actividad )
                        	<th>Actividad</th>
                        @endif
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evidencias as $evidencia)
                        <tr>
                            <td><img width="30px" src="{{ $evidencia->previewimg }}" alt=""></td>
                            <td>{{$evidencia->nombre}}</td>
                            <td>{{$evidencia->descripcion}}</td>
                    		@if ( !$actividad )
	                            <td>
		                            <a href="{{ route('GET_lista_evidencias',['cactividad'=>$evidencia->actividad->cactividad]) }}">
		                                {{ $evidencia->actividad->cactividad }} - {{ $evidencia->actividad->nactividad }}
		                            </a>
	                            </td>
                    		@endif
                            <td>{{$evidencia->fregistro}}</td>
                            <td><a class="btn btn-primary" href="{{$evidencia->path}}" download="">Descargar</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
		</div>
	</div>
@endsection

@section('scripts')
	<!-- <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script> -->
	<!-- <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script> -->
	<script>
		var table= $(".evidencias").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching":true,
			"language": DTspanish
		})
	</script>
@endsection
