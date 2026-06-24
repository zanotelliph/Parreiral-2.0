@extends('main')
@section('titulo', 'Relatório de Compras')
@section('conteudo')

@include('partials.page-header', [
    'title' => 'Relatório de Compras',
    'subtitle' => 'Análise de movimentações e insumos da vinícola',
])

<div class="content-panel mb-4">
    <form method="GET" action="{{ route('relatorios.compras') }}" class="row g-2">
        <div class="col-12 col-md-5">
            <label class="form-label fw-bold">Data Início</label>
            <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="form-control">
        </div>
        <div class="col-12 col-md-5">
            <label class="form-label fw-bold">Data Fim</label>
            <input type="date" name="data_fim" value="{{ $dataFim }}" class="form-control">
        </div>
        <div class="col-12 col-md-2 d-grid d-md-flex align-items-end">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card bg-light border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <h6 class="text-muted text-uppercase small mb-2">Total de Itens Comprados</h6>
                <h3 class="fw-bold text-dark mb-0">{{ $totalQuantidade }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card bg-light border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <h6 class="text-muted text-uppercase small mb-2">Valor Total Investido</h6>
                <h3 class="fw-bold text-success mb-0">R$ {{ number_format($totalGeral, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="content-panel">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-dark"> <tr>
                    <th>PRODUTO</th>
                    <th>ITEM COMPRA</th>
                    <th>PAGAMENTO</th>
                    <th>Quantidade</th>
                    <th>VALOR TOTAL</th>
                    <th>DATA</th>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Nenhuma compra encontrada para o período selecionado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection