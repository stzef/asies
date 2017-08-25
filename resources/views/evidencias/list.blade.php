@extends('layouts.app')

@section('styles')
@endsection
@section('content')

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Evidencias
					@if ( $actividad )
						de la Actividad {{ $actividad->nactividad }}
					@endif
				</h4>
			</div>
		</div>
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
@endsection

@section('scripts')
	<script>
		var table= $(".evidencias").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching":true,
			"language": DTspanish,
			"bLengthChange":false,
            "responsive": true,
		})
	</script>
@endsection
