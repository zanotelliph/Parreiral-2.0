@extends('main')
@section('titulo', 'Gráfico Quantidade de Compras por cliente')
@section('conteudo')

    <div class="container px-4 mx-auto py-6">

        <div class="p-6 my-6 mx-auto bg-white rounded shadow max-w-5xl">
            {!! $chart->container() !!}
        </div>

    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}

@stop