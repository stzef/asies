<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="icon" href="{{ URL::asset('img/logo.png') }}" type="image/png" sizes="16x16">

        <title>{{$SHORT_NAME_APP}}</title>

        <link rel="stylesheet" href="{{ URL::asset('dist/css/bundle.min.css') }}" >

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('styles')
        <style>
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -ms-overflow-style: -ms-autohiding-scrollbar;
            }
            .input-group-find-treetask #cplan, #tarea_cplan{
                width: 20%;
            }
            .input-group-find-treetask #cplan_mask, #tarea_cplan_mask{
                width: 80%;
            }
            .KW_progressContainer {
                left:0;
                width: 100%;
                height: 0.4em;
                margin-bottom: 0px;
                position: fixed;
                bottom: 0px;
                overflow: hidden;
                background-color: white;
                content: "";
                display: table;
                table-layout: fixed;
                z-index:99999;
            }

            .KW_progressBar {
                width: 0%;
                float: left;
                height: 100%;
                z-index:9999;
                max-width: 100%;
                background-color:orange;
                -webkit-transition: width .6s ease;
                -o-transition: width .6s ease;
                transition: width .6s ease;
            }
        </style>
    </head>

    <body>
<div class="KW_progressContainer">
        <div class="KW_progressBar">

        </div>
    </div>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle offcanvas-toggle" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
                        <span class="sr-only">Toggle navigation</span>
                        <span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </span>
                    </button>
                    <a class="navbar-brand" href="{{ URL::route('app_dashboard') }}">{{$SHORT_NAME_APP}}</a>
                </div>
                <ul class="nav navbar-right top-nav hidden-sm hidden-xs">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                            <li class="btn-logout">
                                <a href="{{ url('/logout') }}"><i class="fa fa-fw fa-power-off"></i> Salir </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-offcanvas navbar-offcanvas-touch" id="js-bootstrap-offcanvas">
                    <ul class="nav navbar-nav side-nav">
                        <li >
                            <a href="#" class="hidden-sm hidden-md hidden-lg">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                         <div class="pull-right">
                                                <i
                                                    class="fa fa-chevron-left"
                                                    onclick="$('#js-bootstrap-offcanvas').trigger('offcanvas.close');"
                                                ></i>
                                         </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="hidden-md hidden-lg">
                            <a href="javascript:;" data-toggle="collapse" data-target="#menu-perfil" title="{{ Auth::user()->name }}">
                                <i class="fa fa-user"></i>
                                    {{ str_limit(Auth::user()->name, $limit = 10, $end = '...') }}
                                <b class="caret"></b>
                            </a>
                            <ul id="menu-perfil" class="collapse">
                                <li>
                                    <a href="{{ url('/logout') }}"><i class="fa fa-fw fa-power-off"></i> Salir </a>
                                </li>
                            </ul>
                        </li>
                        <li >
                            <a href="{{ URL::action('AppController@dashboard') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ URL::route('mis_actividades',['user'=>Auth::user()->name]) }}"><i class="fa fa-fw fa-file-text-o"></i> Mis Actividades</a>
                        </li>
                        <!--
                        <li>
                            <a href="{{ URL::route('GET_list_encuestas_user') }}"><i class="fa fa-file-text-o"></i>
                                Mis Encuestas
                            </a>
                        </li>
                        -->
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#actividades"><i class="fa fa-fw fa-cubes"></i> Actividades <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="actividades" class="collapse">
                                <li>
                                    @permission('activities.crud')
                                        <a href="{{ URL::route('GET_actividades_create') }}"><i class="fa fa-fw fa-plus"></i>Crear</a>
                                    @endpermission
                                    @permission('activities.all')
                                        <a href="{{ URL::route('GET_actividades_list') }}"><i class="fa fa-fw fa-list"></i>Listar</a>
                                    @endpermission
                                    @permission('activities.check_dates')
                                        <a href="{{ URL::route('GET_verificar_fechas_actividades') }}"><i class="fa fa-fw fa-calendar"></i>Ver Todas</a>
                                    @endpermission
                                </li>
                            </ul>
                        </li>
                        <!--
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#encuestas"><i class="fa fa-file-text-o"></i> Encuestas <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="encuestas" class="collapse">
                                <li>
                                    @permission('activities.all')
                                        <a href="{{ URL::route('GET_list_encuestas') }}"><i class="fa fa-list"></i>Listado</a>
                                    @endpermission
                                </li>
                            </ul>
                        </li>
                        -->
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#actas">
                                <i class="fa fa-fw fa-file-pdf-o"></i>
                                Actas
                                <i class="fa fa-fw fa-caret-down"></i>
                            </a>
                            <ul id="actas" class="collapse">
                                @permission('actas.crud.list')
                                    <li>
                                        <a href="{{ URL::route('GET_list_actas',['user'=>Auth::user()->name]) }}"><i class="fa fa-list"></i> Listar</a>
                                    </li>
                                @endpermission
                            </ul>
                        </li>
                        @permission('activities.check_dates')
                            <li>
                                <a href="javascript:;" data-toggle="collapse" data-target="#reportes">
                                    <i class="fa fa-fw fa-file-pdf-o"></i>
                                    Reportes
                                    <i class="fa fa-fw fa-caret-down"></i>
                                </a>
                                <ul id="reportes" class="collapse">
                                    <li>
                                        <a href="{{ URL::route('reportes_view_tareas_general') }}"><i class="fa fa-list"></i> Tareas </a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::route('reportes_view_tareas_by_user') }}"><i class="fa fa-list"></i> Tareas por Usuario </a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::route('reportes_view_tareas_between') }}"><i class="fa fa-list"></i> Tareas Rango de Fecha </a>
                                    </li>
                                </ul>
                            </li>
                        @endpermission
                        <li >
                            <a href="{{ URL::route('GET_tareas_create') }}"><i class="fa fa-fw fa-tasks"></i> Tareas</a>
                        </li>
                        <li >
                            <a href="{{ URL::route('GET_lista_evidencias') }}"><i class="fa fa-fw fa-tasks"></i> Evidencias</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div id="page-wrapper">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="container-fluid" id="vue-app">
                    @yield('content')
                </div>
            </div>
        </div>
        <script>
            @if( isset($crud_action) )
                var CRUD_ACTION = "{{ $crud_action }}"
            @else
                var CRUD_ACTION = null
            @endif
        </script>

        <script src="{{ URL::asset('dist/js/bundle.min.js') }}"></script>

        <script>
            $(window).load(function(){
              $(window).scroll(function() {
                var wintop = $(window).scrollTop(), docheight = $('body').height(), winheight = $(window).height();
                var totalScroll = (wintop/(docheight-winheight))*100;
                $(".KW_progressBar").css("width",totalScroll+"%");
              });

            });

            var waitingDialog = {
                /*$('body').loadingModal('text', 'My changed text');
                $('body').loadingModal('animation', 'rotatingPlane');
                $('body').loadingModal('color', '#000');
                $('body').loadingModal('backgroundColor', 'yellow');
                $('body').loadingModal('opacity', '0.9');
                $('body').loadingModal('hide');
                $('body').loadingModal('show');
                $('body').loadingModal('destroy');*/
                show: function(message, options){
                options = options || {}
                $('body').loadingModal({
                    text: message,
                    animation: options.animation || 'threeBounce',//'fadingCircle',
                    position: options.position || 'auto',
                    color: options.color || '#fff',
                    opacity: options.opacity || '1',
                    backgroundColor: options.backgroundColor || 'rgba(0, 0, 0, 0.7)',
                });

                },
                hide: function(){
                    $('body').loadingModal('destroy');
                },
            }
            waitingDialog.show("Cargando la Pagina...")
            $(document).ready(function(){
                waitingDialog.hide()
            })
          $(window).on('beforeunload', function(){
                waitingDialog.show("Por favor espere un momento.")
                window.setTimeout(function(){
                    waitingDialog.hide()
                }, 3000)
           });
        </script>

        <!--<script src="{{ URL::asset('dist/js/app.min.js') }}"></script>-->
        <script src="{{ URL::asset('layout/js/app.js') }}"></script>

        <script>
            // handle jQuery plugin naming conflict between jQuery UI and Bootstrap
            $.widget.bridge('uibutton', $.ui.button);
            $.widget.bridge('uitooltip', $.ui.tooltip);
        </script>

        <script>
          $(function() {
                $('.toggle-do').bootstrapToggle({
                    on: 'Si',
                    off: 'No',
                    onstyle: 'success',
                    offstyle: 'danger',
                });
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
              console.log(thrownError)
            });

            $( "#dialog" ).dialog({
                width : "70%",
                autoOpen: false,
                modal: true,
                resizable: false
            });
            $( "#dialog" ).dialog("open");

        </script>

        <script src="{{ URL::asset('components/dist/build.js') }}"></script>

        @yield('scripts')

    </body>

</html>
