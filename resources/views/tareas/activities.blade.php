@extends('layouts.app')

@section('styles')
@endsection

@section('content')

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Tarea : {{ $tarea->ntarea }}</h4>
                </div>
            </div>

			<div class="">
				<h2> Actividades </h2>
				<table class="table">
					<thead>
						<tr>
							<th> Actividad </th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach( $asignaciones as $asignacion )
							<tr>
								<td>
									{{ $asignacion->actividad->cactividad }} - {{ $asignacion->actividad->nactividad }}
								</td>
								<td>
									@if ( ! $asignacion->actividad->ifhecha )
										<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$asignacion->actividad->cactividad]) }}">Realizar</a>
									@endif
								</td>
								<td>
									<a class="btn btn-info" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$asignacion->actividad->cactividad]) }}">Resumen</a>
								</td>
								<td>
									@permission('activities.crud')
										<a class="btn btn-primary" href="{{ URL::route('GET_actividades_edit',['cactividad'=>$asignacion->actividad->cactividad]) }}">Editar</a>
									@endpermission
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

        </div>

@endsection

@section('scripts')
<script>
</script>
@endsection
