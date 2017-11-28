<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> {{$title}} </title>
	<style>
		@page { margin: 130px 50px; }
		#header { position: fixed; left: 0px; top: -130px; right: 0px; height: 10;  text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 70px;  }
		#footer .page:after { content: counter(page, upper-roman); }
		.text-center{
			text-align: center;
		}
		table{
			width: 100%;
		}
		table tr td{
			border : 1px solid black;

		}

	</style>
	<style>
		.tarea.no_ok{
			color: red;
		}
		.tarea.ok{
			background-color: green;
		}
		ul{
			padding-left: 15px;
		}
	</style>
</head>
<body id="app-layout">

	<header id="header">
	<div class="text-center" style="min-height:100px; ">
		@if( file_exists( public_path().'/img/alcaldias/guataqui/banner.png' ) )
			<img class="banner" src="{{ public_path().'/img/alcaldias/guataqui/banner.png' }}" alt="" width="450px">
		@endif
	</div>
    </header>

    <footer id="footer">
	<div class="text-center">
		<span>“Buen gobierno con transparencia responsabilidad y compromiso social 2016-2019</span><br>
		<span>NIT.800011271-9</span><br>
		<span>CODIGO POSTAL 252820</span>
	</div>
    </footer>

	<h2>{{ $title }}</h2>
	{!!  Helper::output($type, [$plan], $info) !!}
</body>
</html>


