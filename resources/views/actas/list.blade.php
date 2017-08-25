@extends('layouts.app')

@section('styles')
@endsection
@section('content')

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Lista de Actas</h4>
                </div>
            </div>

            <table class="table table-bordered tabla-hover table-responsive" class="display nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numero del Acta</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Elaboró</th>
                        <th>Revisó</th>
                        <th>Aprobó</th>
                        <th>Enviar</th>
                        <th>Imprimir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actas as $acta)
                        <tr>
                            <td>{{$acta->numeroacta}}</td>
                            <td>{{$acta->fhini}}</td>
                            <td>{{$acta->fhfin}}</td>
                            <td>{{$acta->elaboro->persona->nombreCompleto()}}</td>
                            <td>{{$acta->reviso->persona->nombreCompleto()}}</td>
                            <td>{{$acta->aprobo->persona->nombreCompleto()}}</td>
                            <td>
                                <a type="button" class="btn btn-primary" href="{{ URL::route('GET_send_acta',['numeroacta' => $acta->numeroacta]) }}">
                                    <i class="glyphicon glyphicon-send"></i>
                                    Enviar
                                </a>
                            </td>
                            <td>
                                <a type="button" class="btn btn-primary" target="_blank" href="{{ URL::route('GET_pdf_acta',['numeroacta' => $acta->numeroacta]) }}">
                                    <i class="glyphicon glyphicon-print"></i>
                                    Imprimir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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
