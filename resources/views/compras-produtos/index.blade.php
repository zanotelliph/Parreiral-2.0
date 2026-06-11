@extends('main')
@section('titulo', 'Compras de Produtos')
@section('conteudo')

@if(isset($chart))
<div class="card mb-4">
    <div class="card-body">
        {!! $chart->container() !!}
    </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3"><h3>Compras de Produtos</h3><a href="{{ route('compras-produtos.create') }}" class="btn btn-success">Nova compra</a></div>
<form class="row g-2 mb-3" method="GET" action="{{ route('compras-produtos.index') }}">
  <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar fornecedor, produto ou observação"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
</form>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered">
<thead>
<tr>
    <th>ID</th>
    <th>Produto</th>
    <th>Item</th>
    <th>Custo de compra</th>
    <th>Forma de Pagamento</th>
    <th>Parcelas</th>
    <th>Desconto</th>
    <th>Valor Total</th>
    <th>Data</th>
    <th>Descrição</th>
    <th>Ações</th>
</tr>
</thead>
<tbody>
@foreach($compras as $item)
<tr>
    <td>{{ $item->id }}</td>
    <td>{{ $item->produto_id }}</td>
    <td>{{ $item->item_compra }}</td>
    <td>R$ {{ number_format($item->custo_compra, 2, ',', '.') }}</td>
    <td>{{ $item->forma_pagamento }}</td>
    <td>{{ $item->parcelas }}</td>
    <td>{{ $item->desconto }}</td>
    <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
    <td>{{ $item->data_compra }}</td>
    <td>{{ $item->descricao }}</td>
    <td>
        <a class="btn btn-sm btn-primary" href="{{ route('compras-produtos.edit', $item) }}">Editar</a>

        <form class="d-inline" method="POST"
              action="{{ route('compras-produtos.destroy', $item) }}"
              onsubmit="return confirm('Excluir?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Excluir</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
@if(isset($chart))
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endif
@endsection

@include('partials.page-header', [
    'title' => 'Compras de Produtos',
    'subtitle' => 'Movimentações e vendas vinculadas aos clientes',
])

<div class="content-panel">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <form class="row g-2 flex-grow-1" method="GET" action="{{ route('compras-produtos.index') }}">
            <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar cliente, fornecedor, produto ou observação"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
        </form>
        <a href="{{ route('compras-produtos.create') }}" class="btn btn-success text-nowrap">Nova compra</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th><th>Cliente</th><th>Produto</th><th>Fornecedor</th>
                    <th>Quantidade</th><th>Valor total</th><th>Data</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compras as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->cliente?->nome ?? '—' }}</td>
                        <td>{{ $item->produto?->nome ?? $item->produto_id }}</td>
                        <td>{{ $item->fornecedor }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                        <td>{{ $item->data_compra?->format('d/m/Y') }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('compras-produtos.edit', $item) }}">Editar</a>
                            <form class="d-inline" method="POST" action="{{ route('compras-produtos.destroy', $item) }}" onsubmit="return confirm('Excluir?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
 
