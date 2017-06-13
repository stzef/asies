<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> Title </title>

  <style>
    @page { margin: 130px 50px; }
    #header { position: fixed; left: 0px; top: -130px; right: 0px; height: 10;  text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 70px;  }
    #footer .page:after { content: counter(page, upper-roman); }
  </style>

    <!-- Fonts -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">-->
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">-->

    <!-- Styles -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
    <style>
    </style>
    @yield('styles')

</head>
<body id="app-layout">

    <header id="header">
        @yield('header')
    </header>

    <footer id="footer">
        @yield('footer')
    </footer>

    @yield('body')

    @yield('scripts')
</body>
</html>
