@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Lista de Usuarios</h4>
                </div>
            </div>

            <table class="table table-bordered tabla-hover table-responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Identificacion</th>
                        <th>Telefono</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th width="125px">Cargo</th>
                        <th width="125px">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>
                                {{$usuario->id}}
                            </td>
                            <td>
                                {{$usuario->persona->nombres}} {{$usuario->persona->apellidos}}
                            </td>
                            <td>
                                {{$usuario->persona->identificacion}}
                            </td>
                            <td>
                                @if($usuario->persona->telefono)
                                {{$usuario->persona->telefono}}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($usuario->persona->celular)
                                {{$usuario->persona->celular}}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                {{$usuario->email}}
                            </td>
                            <td>
                                {{$usuario->persona->tiempleado->ntiempleado}}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-block" href="{{ URL::route('edit_user',$usuario->id) }}">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>    
    </div>

@endsection

@section('scripts')
    <script>
        var table = $(".table").DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "searching":true,
            "language": DTspanish,
            "bLengthChange": false,
            "responsive": true,
        })
    </script>
@endsection
