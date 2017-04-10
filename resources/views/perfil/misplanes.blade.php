@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('jstree/css/themes/default/style.min.css') }}" >
@endsection


@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Mis Planes <small></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Planes
				</li>

			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Planes
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>Actividad</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($planes as $plan)
								<tr>
									<td>{{ $plan->nplan }}</td>
									<td><button class="btn btn-success">Realizar</button></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
@endsection
