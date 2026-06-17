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

@include('partials.page-header', [
    'title' => 'Compras de Produtos',
    'subtitle' => 'Movimentações e vendas vinculadas aos clientes',
])

<div class="content-panel">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <form class="row g-2 flex-grow-1" method="GET" action="{{ route('compras-produtos.index') }}">
            <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar cliente, produto ou observação"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
        </form>
        <a href="{{ route('compras-produtos.create') }}" class="btn btn-success text-nowrap">Nova compra</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr>
                <th>PRODUTO</th>
                <th>ITEM COMPRA</th>
                <th>PAGAMENTO</th>
                <th>QTD</th>
                <th>VALOR TOTAL</th>
                <th>DATA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $compra)
                <tr>
                    <td>{{ $compra->produto->nome ?? 'Produto #' . $compra->produto_id }}</td>
                    <td>{{ $compra->item_compra ?? '-' }}</td>
                    <td>{{ $compra->forma_pagamento ?? '-' }}</td>
                    <td>{{ $compra->quantidade }}</td>
                    <td class="text-nowrap">R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                    <td class="text-nowrap">{{ $compra->data_compra ? $compra->data_compra->format('d/m/Y') : '-' }}</td>
                    <td>
                        <div class="d-grid d-sm-flex gap-2">
                            <a class="btn btn-sm btn-primary" href="{{ route('compras-produtos.edit', $compra->id) }}">Editar</a>
                            <form method="POST" action="{{ route('compras-produtos.destroy', $compra->id) }}" onsubmit="return confirm('Excluir?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger w-100">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhuma compra encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($chart))
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endif
@endsection
