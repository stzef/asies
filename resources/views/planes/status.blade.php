@extends('layouts.app')

@section('styles')
@endsection


@section('content')
	<input type="hidden" name="treetask_cplan" id="treetask_cplan" value="{{ $plan->cplan }}">
	<input type="hidden" :value="treetask_select" id="treetask_select">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<h4>{{ $plan->nplan }}</h4>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<input type="text" id="treeview_find" value="" placeholder="Buscar..." class="input" style="margin:0em auto 1em auto; display:block; padding:4px; border-radius:4px; border:1px solid silver;">
				</div>
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
<script>
      var to = false;
      $('#treeview_find').keyup(() => {
        if(to) { clearTimeout(to); }
        to = setTimeout(() => {
          var v = $('#treeview_find').val();
          $( $("#treetask_select").val() ).jstree(true).search(v);
        }, 250);
      });
</script>
@endsection
