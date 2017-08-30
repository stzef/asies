@extends('layouts.app')

@section('styles')
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-7">
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
				</div>
			</div>

			<div>
				<div class="panel panel-default">
					<div class="panel-body p-0" id="encuesta">
						<input type="hidden" value="{{ $encuesta->cencuesta }}" id="cencuesta" name="cencuesta">
						@foreach( $encuesta->preguntas as $i => $pregunta )
							@php $i++ @endphp
							<div class="panel panel-default hide encuestadeta_page" id="encuestadeta_page_{{$i}}" data-page="{{$i}}">
								<div class="panel-heading">
									<div>
										<input type="hidden" name="cpregunta" value="{{ $pregunta->cpregunta }}" data-text="{{ $pregunta->enunciado }}">
										#{{$i}} - {{ $pregunta->enunciado }}
									</div>
								</div>

								<div class="panel-body">
									<div>
										<label> Respuesta: </label>
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
									</div>
									<div class="row">

										<!--
										<div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-md-12">
											<label> Anotaciones: </label>
											<p>@if($pregunta->respuesta){{$pregunta->respuesta->anotaciones}}@endif</p>
										</div>
										-->
										<!--
										<div class="col-xs-12 col-sm-12 col-md-12 col-md-12">
											<div class="mb-3 col-xs-12 col-sm-12 col-md-9 col-lg-9">
												<label class="col-md-4" for="evidencia_{{ $pregunta->cpregunta }}">
													Adjuntar Evidencia
												</label>
												<div class="col-md-8">
													<input
														{{-- data-cactividad="{{$actividad->cactividad}}" --}}
														data-cpregunta="{{$pregunta->cpregunta}}"
														type="file"
														name="evidencia_{{ $pregunta->cpregunta }}"
														id="evidencia_{{ $pregunta->cpregunta }}"
														multiple
														class="files_encuesta"
													>
												</div>
											</div>
											<div class="mb-3 col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
												<button type="button" class="btn btn-success" onclick="submitFiles(event,this)" data-input="#evidencia_{{ $pregunta->cpregunta }}" > Subir Archivos </button>
											</div>
										</div>
										-->
									</div>
								</div>

							</div>
						@endforeach

						<div id="encuestadeta_pagination"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

	<script type="text/javascript">
		/*
		$(".files_encuesta").fileinput({
			'language': 'es',
			'previewFileType':'any',
			'showPreview' : false,
			'showUpload' : false,
		})
		*/
		function submitFiles(event,button){
			var input = $(button.dataset.input)[0]
			storeEvidenciaencuesta(input)
		}

		/*
		function storeEvidenciaencuesta(input){
			if ( input.files.length != 0 ){
				var data = new FormData();
				$.each(input.files, function(i, file) {
					data.append('files[]', file);
				});

				{{-- var url = "{{ URL::route('POST_store_evidence_answer',['cactividad' => 'cactividad', 'cpregunta' => 'cpregunta']) }}" --}}

				$.ajax({
					url: url.set("cactividad",input.dataset.cactividad).set("cpregunta",input.dataset.cpregunta),
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success: function(data){
						$(input).fileinput('clear');
						alertify.success("El archivo se subi exitosamente.");
					},
					error: function(data){
						alertify.success("Error al subir el archivo.");
					}
				});
			}else{
				alertify.error("No ha seleccionado ningun archivo.");
			}
		}
		*/

		function getEncuesta(page){
			if ( typeof page == "undefined"){
				selector = "#encuesta .encuestadeta_page"
			}else{
				selector = "#encuesta .encuestadeta_page[data-page=" + page + "]"
			}
			var data = []
			$(selector).toArray().forEach( div => {
				var obj = {}
				obj.cpregunta = $(div).find("[name=cpregunta]").val()
				obj.cpregunta_text = $(div).find("[name=cpregunta]").data("text")

				obj.isOpenQuestion = eval($(div).find("[name=isOpenQuestion]").val())

				obj.anotaciones = $(div).find("[name=anotaciones]").val()

				if ( obj.isOpenQuestion ){
					element = $(div).find("input[type=radio]")
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

		$("#btn_guardar").click(function(event){
			guardarEncuesta()
			$("a[href='#tab_tareas']").tab("show")
		})
		$(function() {
			$("#encuestadeta_pagination").pagination({
				items: {{ $encuesta->cantidad_preguntas }},
				itemsOnPage: 1,
				displayedPages: 3,
				cssStyle: 'light-theme',
				prevText: "<",
				nextText: ">",
				selectOnClick: true,
				//beforeChange: function(currentPageNumber,nextPageNumber, event){},
				onPageClick: function(lastPageIndex,pageNumber, event){
					var selectorPageSelect = "#encuestadeta_page_" + pageNumber
					$(".encuestadeta_page").addClass("hide")
					$(selectorPageSelect).removeClass("hide")
				},
				onInit: function(){
					var pageNumber = $("#encuestadeta_pagination").pagination('getCurrentPage');
					var selectorPageSelect = "#encuestadeta_page_" + pageNumber
					$(selectorPageSelect).removeClass("hide")
				}
			});
		});
	</script>

	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->
@endsection
