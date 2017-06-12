@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.css') }}" >
@endsection


@section('content')
	<input type="hidden" name="treetask_cplan" id="treetask_cplan" value="{{ $plan->cplan }}">

	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Planes</div>
				<div class="panel-body">
					<div>
						<task-tree :tiplanes="tiplanes" :planes="planes" @tt_mounted="loadDataTaskTree" @ctt="setActiveTaskTree" />
					</div>
					<div class="panel">
						@include('partials.activities_grouped',['actividades',$actividades])
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ URL::asset('vendor/jstree/js/jstree.min.js') }}"></script>

	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>

@endsection
