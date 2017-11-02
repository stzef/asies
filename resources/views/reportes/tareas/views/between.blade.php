@extends('layouts.app')

@section('styles')

@endsection


@section('content')

	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Reporte de tareas por Fecha</h4>
				</div>
			</div>

			<div>
				<form id="form_report" class="form-horizontal" target="_blank" method="GET" action="{{ URL::route('reportes_tareas_general') }}">

					<!--<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">-->
					<input type="hidden" name="type" value="date">
					
					<div class="form-group">
						<label for="cplan" class="col-sm-4 col-form-label">Plan</label>
						<div class="col-sm-8">
							<div class="input-group input-group-find-treetask">
								<input type="text" class="form-control" id="cplan" name="cplan" placeholder="Código">
								<input type="text" readonly class="form-control" id="cplan_mask" name="cplan_mask" placeholder="Plan">
								<span class="input-group-addon" data-find-plan data-find-treetask data-input-reference="#cplan"><i class="fa fa-search"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-sm-4 col-form-label" >Fecha Inicial</label>
						<div class='col-sm-7 input-group date'>
							<input type='text' class="form-control" name="fini" required />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-sm-4 col-form-label">Fecha Final</label>
						<div class='col-sm-7 input-group date'>
							<input type='text' class="form-control" name="ffin" required />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</form>

				<div class="text-center">

					<button type="submit" class="btn btn-success" form="form_report">
						<i class="glyphicon glyphicon-plus"></i>
						Generar
					</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(function () {
			$('.date').datetimepicker({
				format: 'YYYY-MM-DD',
				defaultDate: moment().format("YYYY-MM-DD")
			});
		});
	</script>

@endsection
