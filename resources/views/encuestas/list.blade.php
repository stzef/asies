@extends('layouts.app')

@section('styles')
@endsection
@section('content')

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Encuestas
				</h4>
			</div>
		</div>
        <table class="encuestas table table-bordered tabla-hover " cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hisencuestas as $hisencuesta)
                    <tr>
                        <td>{{$hisencuesta->encuesta->nombre}}</td>
                        <td>{{$hisencuesta->encuesta->descripcion}}</td>
                        <td>{{$hisencuesta->encuesta->date}}</td>
                        <td>
                            @if( $hisencuesta->ifhecha )
                                <a class="btn btn-success" href="{{ URL::route('GET_mostrar_encuesta',['id' => $hisencuesta->chencuesta ]) }}">
                                    Ver Respuestas
                                </a>
                            @else
                                <a class="btn btn-primary" href="{{ URL::route('GET_realizar_encuesta',['id' => $hisencuesta->chencuesta ]) }}">
                                    Contestar
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
	</div>
@endsection

@section('scripts')
	<script>
		var table= $(".encuestas").DataTable({
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
