@extends('layouts.app')

@section('styles')
@endsection


@section('content')
	<task-tree  :tiplanes="tiplanes" :planes="planes" @tt_mounted="loadDataTaskTree" @ctt="setActiveTaskTree" />
@endsection

@section('scripts')
@endsection
