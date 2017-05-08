<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ URL::asset('img/logo.png') }}" type="image/png" sizes="16x16">

    <title>{{$SHORT_NAME_APP}}</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('layout/css/bootstrap.min.css') }}" >
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ URL::asset('layout/css/sb-admin.css') }}" >
    <!--<link href="css/sb-admin.css" rel="stylesheet">-->

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('layout/font-awesome/css/font-awesome.min.css') }}" >

    <!--<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->

    <!-- AlertifyJS -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/alertifyjs/css/alertify.min.css') }}" >

    <!-- JQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" >

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/select2-4.0.3/dist/css/select2.min.css') }}" >

    <!-- JTable -->
    <!--<link rel="stylesheet" href="{{ URL::asset('vendor/jtable.2.4.0/themes/jqueryui/jtable_jqueryui.css') }}" >-->
    <link rel="stylesheet" href="{{ URL::asset('vendor/jtable.2.4.0/themes/metro/darkgray/jtable.css') }}" >

    <!-- Datetimepicker JS -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/datetimepicker/css/bootstrap-datetimepicker-standalone.css') }}" >


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')

</head>

<body>

    <div>
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ URL::asset('layout/js/jquery.js') }}"></script>

    <!-- JQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script>
        // handle jQuery plugin naming conflict between jQuery UI and Bootstrap
        $.widget.bridge('uibutton', $.ui.button);
        $.widget.bridge('uitooltip', $.ui.tooltip);
    </script>

    <!-- Bootstrap JavaScript -->
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('layout/js/bootstrap.min.js') }}"></script>

    <!-- Moment JS -->
    <script src="{{ URL::asset('vendor/momentjs/moment-with-locales.js') }}"></script>
    <script src="{{ URL::asset('vendor/momentjs/locale/es.js') }}"></script>

    <script src="{{ URL::asset('vendor/datetimepicker/bootstrap/js/transition.js') }}"></script>
    <script src="{{ URL::asset('vendor/datetimepicker/bootstrap/js/collapse.js') }}"></script>



    <!-- Datetimepicker JS -->
    <script src="{{ URL::asset('vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ URL::asset('layout/js/app.js') }}"></script>

    <!-- AlertifyJS -->
    <script src="{{ URL::asset('vendor/alertifyjs/alertify.min.js') }}"></script>


    <!-- JTable -->
    <script src="{{ URL::asset('vendor/jtable.2.4.0/jquery.jtable.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ URL::asset('vendor/select2-4.0.3/dist/js/select2.full.min.js') }}"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('select').select2();

        $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
          console.log(thrownError)
        });
    </script>
    @yield('scripts')

</body>

</html>
