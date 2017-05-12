@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Alcaldias<b></b></div>

                <div class="panel-body">
                	{{-- @foreach ( $alcaldias as $alcaldia )
                		<div class="col-lg-3 col-md-6">
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <img width="80px" src="{{ URL::asset('static/alcaldias/guataqui/logo.png') }}" alt="">
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <!--<div class="huge">26</div>-->
		                                    <div><h4>{{ $alcaldia }}</h4></div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="//{{ $alcaldia }}.{{ $server_name }}/login">
		                            <div class="panel-footer">
		                                <span class="pull-left">Ingresar</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>
                	@endforeach --}}


                		<div class="col-lg-3 col-md-6">
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <img width="80px" src="{{ URL::asset('static/alcaldias/guataqui/logo.png') }}" alt="">
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <!--<div class="huge">26</div>-->
		                                    <div><h4>guataqui</h4></div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="//guataqui.controlasies.com.co/login">
		                            <div class="panel-footer">
		                                <span class="pull-left">Ingresar</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>
                		<div class="col-lg-3 col-md-6">
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <img width="80px" src="{{ URL::asset('static/alcaldias/anapoima/logo.png') }}" alt="">
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <!--<div class="huge">26</div>-->
		                                    <div><h4>anapoima</h4></div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="//anapoima.controlasies.com.co/login">
		                            <div class="panel-footer">
		                                <span class="pull-left">Ingresar</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>
                		<div class="col-lg-3 col-md-6">
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <img width="80px" src="{{ URL::asset('static/alcaldias/jerusalen/logo.png') }}" alt="">
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <!--<div class="huge">26</div>-->
		                                    <div><h4>jerusalen</h4></div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="//jerusalen.controlasies.com.co/login">
		                            <div class="panel-footer">
		                                <span class="pull-left">Ingresar</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>

                </div>





                </div>
            </div>
        </div>
    </div>
</div>
@endsection
