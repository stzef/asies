@extends('layouts.app')

@section('styles')
@endsection


@section('content')
	<input type="hidden" name="treetask_cplan" id="treetask_cplan" value="{{ $plan->cplan }}">


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Planes</h4>
				</div>
			</div>

			<div class="">
				<div>
					<task-tree :tiplanes="tiplanes" :planes="planes" @tt_mounted="loadDataTaskTree" @ctt="setActiveTaskTree" />
				</div>
				<div class="panel">
					@include('partials.activities_grouped',['actividades',$actividades])
				</div>

			</div>
		</div>

@endsection

@section('scripts')
@endsection
