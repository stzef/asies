@extends('layouts.independent')

@section('styles')
	<style>
		body{
			background: inherit;
		}
	</style>
@endsection


@section('content')
	<task-tree  :tiplanes="tiplanes" :planes="planes" @tt_mounted="loadDataTaskTree" @ctt="setActiveTaskTree" />
@endsection

@section('scripts')

@endsection
