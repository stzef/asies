@extends('layouts.app')

@section('styles')
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div>
						<h4 class="text-center">
							Encuesta: {{ $encuesta->nombre }}
						</h4>
						<h5>
							{{ $encuesta->descripcion }}
						</h5>
					</div>
				</div>
			</div>

			<div>
				@if ( $encuesta->ifhecha )
					<div class="panel panel-default bg-success">
						<div class="panel-heading">
							<h4>Encuesta Completada</h4>
							<a href="{{ URL::route('GET_mostrar_encuesta',['chencuesta'=> $encuesta->his->chencuesta]) }}" class="btn btn-primary"> Ver Respuestas </a>
						</div>
					</div>
				@else
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
											<tr class="encuestadeta_page" data-page="{{$i}}">
												<td>
													<input type="hidden" name="cpregunta" value="{{ $pregunta->cpregunta }}" data-text="{{ $pregunta->enunciado }}">
													{{$i}} - {{ $pregunta->enunciado }}
												</td>
												<td>
													@if ( $pregunta->isOpenQuestion() )
														<input type="hidden" name="isOpenQuestion" value="true">
														<textarea
															style="resize:none"
															class="form-control respuesta"
															name="copcion"
															data-text="Respuesta Abierta"
															required
														>@if($pregunta->respuesta){{$pregunta->respuesta->respuesta}}@endif</textarea>
													@else
														<input type="hidden" name="isOpenQuestion" value="false">
														@foreach($pregunta->opciones as $opcion)
															<div>
																<label for="copcion_{{ $opcion->copcion }}_cpregunta_{{ $pregunta->cpregunta }}">
																	<input
																		type="radio"
																		name="copcion_cpregunta_{{ $pregunta->cpregunta }}"
																		id="copcion_{{ $opcion->copcion }}_cpregunta_{{ $pregunta->cpregunta }}"
																		data-text="{{ $opcion->detalle }}"
																		value="{{ $opcion->copcion }}"
																		class="respuesta"
																		required
																		@if($pregunta->respuesta)
																			@if($pregunta->respuesta->copcion == $opcion->copcion )
																				checked
																			@endif
																		@endif
																	/>
																	<span>{{ $opcion->detalle }}</span>
																</label>
															</div>
														@endforeach
													@endif
												</td>
											</tr>
									@endforeach
								</tbody>
							</table>

							<div
								class="panel panel-default"
							>
								<div class="panel-heading">
									<div>
										<h4> Terminado </h4>
									</div>
								</div>
								<div class="panel-body">
									<div class="row text-center">
											<button type="submit" class="btn btn-primary" id="btn_guardar">
												<i class="glyphicon glyphicon-plus"></i> Guardar y salir
											</button>
										</div>
								</div>
							</div>
							<div id="encuestadeta_pagination"></div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection

@section('scripts')

	<script type="text/javascript">


		function getEncuesta(page){
			if ( typeof page == "undefined"){
				selector = "#encuesta .encuestadeta_page"
			}else{
				selector = "#encuesta .encuestadeta_page[data-page=" + page + "]"
			}
			var data = []
			console.log($(selector))
			$(selector).toArray().forEach( div => {
				var obj = {}
				obj.cpregunta = $(div).find("[name=cpregunta]").val()
				obj.cpregunta_text = $(div).find("[name=cpregunta]").data("text")

				obj.isOpenQuestion = eval($(div).find("[name=isOpenQuestion]").val())

				obj.anotaciones = $(div).find("[name=anotaciones]").val()

				if ( obj.isOpenQuestion ){
					element = $(div).find("textarea")
					obj.respuesta = element.val()
					obj.respuesta_text = element.data("text")
					if ( typeof obj.respuesta != 'undefined' ) data.push(obj)
				}else{
					element = $(div).find("input[type=radio]:checked")
					obj.copcion = element.val()
					obj.copcion_text = element.data("text")
					if ( typeof obj.copcion != 'undefined' ) data.push(obj)
				}
			})
			return data
		}

		function guardarEncuesta(page){
			waitingDialog.show("Guardando...")
			$.ajax({
				type: "POST",
				url : "{{ URL::route('POST_answer_encuesta', ['chencuesta' => $encuesta->his->chencuesta]) }}",
				data: JSON.stringify({
					answers : getEncuesta(page),
					cencuesta : $("#cencuesta").val(),
				}),
				contentType: "application/json",
				dataType: "json",
				success: function(response){
					waitingDialog.hide()
					var msg = response.message
					alertify.success(msg)
				},
				error: function(response){
					waitingDialog.hide()
					alertify.error("Error al guardar el encuesta")
				},
			})
		}
		$("#btn_guardar").click(function(event){
			guardarEncuesta()
			$("a[href='#tab_tareas']").tab("show")
		})


	</script>

	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->
@endsection
