@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenido a ASIES  <b>{{ Auth::user()->persona->nombreCompleto() }}</b></div>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
