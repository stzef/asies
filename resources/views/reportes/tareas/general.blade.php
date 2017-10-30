<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
		@page { margin: 130px 50px; }
		#header { position: fixed; left: 0px; top: -130px; right: 0px; height: 10;  text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 70px;  }
		#footer .page:after { content: counter(page, upper-roman); }

		.text-center{
			text-align: center;
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
		@if( file_exists( URL::asset('img/alcaldias/guataqui/banner.png') ) )
			<img  src="{{ URL::asset('img/alcaldias/guataqui/banner.png') }}" alt="" width="450px">
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

	{!!  Helper::output($type, [$plan], $info) !!}
</body>
</html>


