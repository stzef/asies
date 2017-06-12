@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.css') }}" >
@endsection


@section('content')
	<task-tree  :tiplanes="tiplanes" :planes="planes" @tt_mounted="loadDataTaskTree" @ctt="setActiveTaskTree" />
@endsection

@section('scripts')
	<script src="{{ URL::asset('vendor/jstree/js/jstree.min.js') }}"></script>
@endsection
