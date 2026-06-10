@extends('main')

@section('titulo', 'Gráfico de Produtos')

@section('conteudo')

<h2>Produtos Mais Comprados</h2>

{!! $chart->container() !!}

<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}

@endsection