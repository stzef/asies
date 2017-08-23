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
