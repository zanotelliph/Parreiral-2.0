@extends('main')

@section('titulo', 'Gráfico de Reservas')

@section('conteudo')

<h3>Eventos Mais Reservados</h3>

{!! $chart->container() !!}

<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}

@endsection