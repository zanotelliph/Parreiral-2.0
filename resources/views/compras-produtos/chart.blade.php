@extends('main')

@section('titulo', 'Grafico de Compras')

@section('conteudo')

@include('partials.page-header', [
    'title' => 'Produto Mais Comprado',
    'subtitle' => 'Resumo visual das compras registradas',
])

<div class="content-panel">
    {!! $chart->container() !!}
</div>

<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}

@endsection
