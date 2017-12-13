@extends('layouts.app')

@section('styles')
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="text-center">
						Encuesta {{ $encuesta->nombre }}
					</h4>
					<h5>
						{{ $encuesta->descripcion }}
					</h5>
				</div>
				<div class="col-md-5 text-center">
					<div class="btn-group">
					</div>
				</div>
			</div>

			<div>
				<div class="panel panel-default">
					<div class="panel-body p-0" id="encuesta">
						<input type="hidden" value="{{ $encuesta->cencuesta }}" id="cencuesta" name="cencuesta">

							<table class="table">
								<thead>
									<tr>
										<th>Pregunta</th>
										<th>Respuesta</th>
									</tr>
								</thead>
								<tbody>
									@foreach( $encuesta->preguntas as $i => $pregunta )
										@php $i++ @endphp
										<tbody>
											<tr id="encuestadeta_page_{{$i}}" data-page="{{$i}}">
												<td>
													<input type="hidden" name="cpregunta" value="{{ $pregunta->cpregunta }}" data-text="{{ $pregunta->enunciado }}">
													{{$i}} - {{ $pregunta->enunciado }}
												</td>
												<td>
													@if($pregunta->respuesta)
														@if ( $pregunta->isOpenQuestion() )
															<p>
																{{$pregunta->respuesta->respuesta}}
															</p>
														@else
															<p>
																@if ( $pregunta->respuesta->opcion )
																	{{ $pregunta->respuesta->opcion->detalle }}
																@endif
															</p>
														@endif
													@endif
												</td>
											</tr>
										</tbody>
									@endforeach
								</tbody>
							</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

@endsection
