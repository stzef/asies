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
        <!-- Bootstrap Core CSS -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('layout/css/bootstrap.css') }}" > -->
        <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->

        <!-- Custom CSS -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('layout/css/sb-admin.css') }}" > -->
        <!--<link href="css/sb-admin.css" rel="stylesheet">-->

        <!-- Custom Fonts -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('layout/font-awesome/css/font-awesome.min.css') }}" > -->

        <!--<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->

        <!-- AlertifyJS -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('vendor/alertifyjs/css/alertify.css') }}" > -->

        <!-- JQuery UI -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.css') }}" > -->
        <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" > -->

        <!-- Select2 -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('vendor/select2-4.0.3/dist/css/select2.min.css') }}" > -->

        <!-- JTable -->
        <!--<link rel="stylesheet" href="{{ URL::asset('vendor/jtable.2.4.0/themes/jqueryui/jtable_jqueryui.css') }}" >-->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('vendor/jtable.2.4.0/themes/metro/darkgray/jtable.css') }}" > -->

        <!-- Datetimepicker JS -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('vendor/datetimepicker/css/bootstrap-datetimepicker-standalone.css') }}" > -->

        <!-- OK <link href="{{ URL::asset('bootstrap-toggle/bootstrap-toggle.min.css') }}" rel="stylesheet"> -->
        <!-- OK <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-offcanvas/dist/css/bootstrap.offcanvas.min.css') }}"/> -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- OK <link href="{{ URL::asset('css/utilities.css') }}" rel="stylesheet"> -->
        <!-- OK <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet"> -->
        <!-- OK <link href="{{ URL::asset('jquery-loadingModal/css/jquery.loadingModal.css') }}" rel="stylesheet"> -->

        @yield('styles')

    </head>

    <body>

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
        <script src="{{ URL::asset('dist/js/app.min.js') }}"></script>
        <!-- jQuery -->
        <!-- OK <script src="{{ URL::asset('layout/js/jquery.js') }}"></script> -->

        <!-- OK <script src="{{ URL::asset('jquery-loadingModal/js/jquery.loadingModal.min.js') }}"></script> -->

        <script>
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
                    animation: options.animation || 'wanderingCubes',
                    position: options.position || 'auto',
                    color: options.color || '#fff',
                    opacity: options.opacity || '0.5',
                    backgroundColor: options.backgroundColor || 'rgba(0, 0, 0, 0.5)',
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
        </script>

        <!-- JQuery UI -->
        <!-- OK <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script> -->

        <script>
            // handle jQuery plugin naming conflict between jQuery UI and Bootstrap
            $.widget.bridge('uibutton', $.ui.button);
            $.widget.bridge('uitooltip', $.ui.tooltip);
        </script>

        <!-- AlertifyJS -->
        <!-- OK <script src="{{ URL::asset('vendor/alertifyjs/alertify.min.js') }}"></script> -->

        <!-- Select2 -->
        <!-- OK <script src="{{ URL::asset('vendor/select2-4.0.3/dist/js/select2.full.min.js') }}"></script> -->

        <!-- OK <script src="{{ URL::asset('layout/js/bootstrap.min.js') }}"></script> -->
        <!-- OK <script src="{{ URL::asset('layout/js/app.js') }}"></script> -->

        <!-- Bootstrap JavaScript -->
        <!-- Bootstrap Core JavaScript -->

        <!-- Moment JS -->
        <!-- OK <script src="{{ URL::asset('vendor/momentjs/moment-with-locales.js') }}"></script> -->
        <!-- OK <script src="{{ URL::asset('vendor/momentjs/locale/es.js') }}"></script> -->

        <!-- OK <script src="{{ URL::asset('vendor/datetimepicker/bootstrap/js/transition.js') }}"></script> -->
        <!-- OK <script src="{{ URL::asset('vendor/datetimepicker/bootstrap/js/collapse.js') }}"></script> -->
        <!-- Datetimepicker JS -->
        <!-- OK <script src="{{ URL::asset('vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script> -->
        <!-- JTable -->
        <!-- OK <script src="{{ URL::asset('vendor/jtable.2.4.0/jquery.jtable.min.js') }}"></script> -->
        <!-- OK <script src="{{ URL::asset('bootstrap-toggle/bootstrap-toggle.min.js') }}"></script> -->
        <!-- OK <script src="{{ URL::asset('bower_components/bootstrap-offcanvas/dist/js/bootstrap.offcanvas.min.js') }}"></script> -->
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
