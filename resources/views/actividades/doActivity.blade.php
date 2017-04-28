@extends('layouts.app')

@section('styles')
	<!-- Bootstrap styles -->
	<!--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
	<!-- Generic page styles -->
	<link rel="stylesheet" href="{{ URL::asset('jQuery-File-Upload-9.18.0/css/style.css') }}">
	<!-- blueimp Gallery styles -->
	<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="{{ URL::asset('jQuery-File-Upload-9.18.0/css/jquery.fileupload.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui.css') }}">
	<!-- CSS adjustments for browsers with JavaScript disabled -->
	<noscript><link rel="stylesheet" href="{{ URL::asset('jQuery-File-Upload-9.18.0/css/jquery.fileupload-noscript.css') }}"></noscript>
	<noscript><link rel="stylesheet" href="{{ URL::asset('jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui-noscript.css') }}"></noscript>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Realizando Actividad : {{ $actividad->nactividad }}
                </div>

                <div class="panel-body">
                    <div class="col-md-6">
                        <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="cactividad" id="cactividad" value="{{ $actividad->cactividad }}">
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="row fileupload-buttonbar">
                                <div class="col-lg-5">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Agregar Archivos...</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                    <button type="submit" class="btn btn-primary start">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Subir Todos</span>
                                    </button>
                                    <button type="reset" class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Carcelar Subida</span>
                                    </button>
                                    <!--
                                    <button type="button" class="btn btn-danger delete">
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                    <input type="checkbox" class="toggle">
                                    -->

                                    <!-- The global file processing state -->
                                    <span class="fileupload-process"></span>
                                </div>
                                <!-- The global progress state -->
                                <div class="col-lg-3 fileupload-progress fade">
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <!-- The extended global progress state -->
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalCrearActa">
                                <i class="glyphicon glyphicon-plus"></i>
                                Crear Acta
                            </button>
                        </div>
                        @foreach ($tareas as $tarea)
                            <div class="form-group row">
                                <!--<label class="col-sm-2"></label>-->
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" onclick="cambiarEstadoTarea(event,this)" type="checkbox" data-ctarea="{{ $tarea->ctarea }}" name="ctarea_{{ $tarea->ctarea }}" @if ($tarea->ifhecha) checked @endif> {{ $tarea->ntarea }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCrearActa" tabindex="-1" role="dialog" aria-labelledby="modalCrearActaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="modal-title" id="modalCrearActaLabel">Crear Acta</h2>
                    </div>

                <div class="row modal-body">
                    <form id="form_crear_acta" class="form-horizontal">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="plan_nombre" class="col-sm-2 col-form-label">Numero</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="plan_nombre" name="actividad[nactividad]" value="{{$numacta}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Objetivos</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="" name="actividad[descripcion]"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Orden del dia</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="" name="actividad[descripcion]"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="plan_nombre" class="col-sm-2 col-form-label">Pie de firma</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="plan_nombre" name="actividad[nactividad]" placeholder="Ciudad, DD/MM/YY">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Elaboro </label>
                                    <div class="col-sm-10">
                                        <select name="" class="form-control">
                                            <option value="">Seleccione...</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}} ( {{$usuario->name}} )</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Reviso </label>
                                    <div class="col-sm-10">
                                        <select name="" class="form-control">
                                            <option value="">Seleccione...</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}} ( {{$usuario->name}} )</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Aprobo </label>
                                    <div class="col-sm-10">
                                        <select name="" class="form-control">
                                            <option value="">Seleccione...</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}} ( {{$usuario->name}} )</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Hora Inicial</label>
                                            <div class='col-sm-8 input-group date'>
                                                <input type='text' class="form-control" name="actividad[fini]"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Hora Final</label>
                                            <div class='col-sm-8 input-group date'>
                                                <input type='text' class="form-control" name="actividad[fini]"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                    </div>
                                    <table id="usuarios_tareas" class="table table-bordered tabla-hover table-responsive" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Funcion</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                    </form>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">
                            <i class="glyphicon glyphicon-print"></i> Imprimir
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="glyphicon glyphicon-send"></i> Enviar
                        </button>
                        <button type="submit" class="btn btn-primary" form="form_crear_acta">
                            <i class="glyphicon glyphicon-plus"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="glyphicon glyphicon-remove"></i> Cancelar
                        </button>
                    </div>
            </div>
        </div>
    </div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <input class="form-control" placeholder="Nombre" type="text" name="nombres[]">
            </td>
            <td>
                <input class="form-control" placeholder="Descripcion" type="text" name="descripciones[]">
            </td>
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Subir</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancelar</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                </span>
            </td>
            <td>
                <p class="name">
                    {% if (file.url) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    {% } else { %}
                        <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>

@endsection

@section('scripts')
    <script>
        function cambiarEstadoTarea(event,element){
            var ctarea = $(element).data("ctarea")
            var ifhecha = element.checked ? 1 : 0
            var base_url_cambio_estado_tarea = "{{ URL::route('POST_cambiar_estado_tarea',['ctarea' => '__ctarea__']) }}"
            $.ajax({
                url : base_url_cambio_estado_tarea.set("__ctarea__",ctarea),
                type : "POST",
                data : { ctarea : ctarea, ifhecha : ifhecha },
                success : function(reponse){},
                error : function(reponse){},
            })
        }
        var cols = {
            ctarea : 0,
            ntarea : 1,
            crespo : 2,
            nrespo : 3,
            ctirela: 4,
            ntirela: 5,
            }
            var table= $("#tareas").DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "language": idioma_espanol,
            "columnDefs": [
                {
                    "targets": [ cols.ctarea,cols.crespo,cols.ctirela ],
                    "visible": false,
                },
            ]

            //editar("#usuarios tbody");
        })
        var table= $("#usuarios").DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "language": idioma_espanol,
            "columnDefs": [
                {
                    "targets": [ cols.ctarea,cols.crespo,cols.ctirela ],
                    "visible": false,
                },
            ]

            //editar("#usuarios tbody");
        })
        var listar = function(){
            var ctarea = $($tareas.);
            var cresponsable = $( "#respo option:selected" ).val();
            var ctirespo = $( "#tirespo option:selected" ).val();
            var ntarea = $( "#tarea option:selected" ).text();
            var nresponsable = $( "#respo option:selected" ).text();
            var ntirespo = $( "#tirespo option:selected" ).text();
            //$("#tarea").val()
            table
                .row.add([ctarea,ntarea,cresponsable,nresponsable,ctirespo,ntirespo,
                    "<button type='button' class='editar btn btn-primary' onclick='editar(event,this)'>"+
                        "<i class='fa fa-pencil-square-o'></i>"+
                    "</button>",
                    "<button type='button' class='eliminar btn btn-danger' onclick='borrar(event,this)''>"+
                        "<i class='fa fa-trash-o'></i>"+
                    "</button>"])
                .draw()
        }
    </script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
	<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/vendor/jquery.ui.widget.js') }}"></script>
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
	<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
	<!--<script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
	<!-- blueimp Gallery script -->
	<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.iframe-transport.js') }}"></script>
	<!-- The basic File Upload plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload.js') }}"></script>
	<!-- The File Upload processing plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload-process.js') }}"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload-image.js') }}"></script>
	<!-- The File Upload audio preview plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload-audio.js') }}"></script>
	<!-- The File Upload video preview plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload-video.js') }}"></script>
	<!-- The File Upload validation plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload-validate.js') }}"></script>
	<!-- The File Upload user interface plugin -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/jquery.fileupload-ui.js') }}"></script>
	<!-- The main application script -->
	<script src="{{ URL::asset('jQuery-File-Upload-9.18.0/js/main.js') }}"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->
@endsection
