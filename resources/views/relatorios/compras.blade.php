@extends('main')

@section('titulo', 'Relatório de Compras')

@section('conteudo')
@include('partials.page-header', [
    'title' => 'Relatório de Compras',
    'subtitle' => 'Compras vinculadas aos clientes com filtros por período',
])

<div class="content-panel">
    <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">Voltar ao painel</a>
    </div>

    <form class="row g-3 mb-4" method="GET" action="{{ route('relatorios.compras') }}">
        <div class="col-md-3">
            <label class="form-label">Data início</label>
            <input type="date" name="data_inicio" class="form-control" value="{{ $dataInicio }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Data fim</label>
            <input type="date" name="data_fim" class="form-control" value="{{ $dataFim }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Cliente</label>
            <select name="cliente_id" class="form-select">
                <option value="">Todos os clientes</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" @selected($clienteId == $cliente->id)>{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card card-parreiral stat-card">
                <div class="card-body">
                    <p class="stat-label mb-1">Total de registros</p>
                    <p class="stat-value mb-0">{{ $compras->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-parreiral-gold stat-card">
                <div class="card-body">
                    <p class="stat-label mb-1">Valor total filtrado</p>
                    <p class="stat-value mb-0">R$ {{ number_format($totalGeral, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th><th>Cliente</th><th>Produto</th>
                    <th>Quantidade</th><th>Valor total</th><th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                    <tr>
                        <td>{{ $compra->id }}</td>
                        <td>{{ $compra->cliente?->nome ?? '—' }}</td>
                        <td>{{ $compra->produto?->nome ?? $compra->produto_id }}</td>
                        <td>{{ $compra->quantidade }}</td>
                        <td>R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                        <td>{{ $compra->data_compra?->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Nenhuma compra encontrada para os filtros selecionados.</td>
                    </tr>
                @endforelse
            </tbody>
            @if($compras->isNotEmpty())
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Totais</td>
                        <td>{{ $totalQuantidade }}</td>
                        <td>R$ {{ number_format($totalGeral, 2, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection