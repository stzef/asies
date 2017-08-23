@extends('layouts.app')

@section('styles')
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
@endsection
