@extends('main')

@section('titulo', 'Relatório de Clientes')

@section('conteudo')
@include('partials.page-header', [
    'title' => 'Relatório de Clientes',
    'subtitle' => 'Identificadores únicos, status financeiro e histórico de compras',
])

<div class="content-panel">
    <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
    
        <a href="{{ url('/') }}" class="btn btn-secondary">Voltar ao painel</a>
    </div>

    <form class="row g-3 mb-4" method="GET" action="{{ route('relatorios.clientes') }}">
        <div class="col-md-4">
            <label class="form-label">Status financeiro</label>
            <select name="status_financeiro" class="form-select">
                <option value="">Todos</option>
                <option value="em dia" @selected($status === 'em dia')>Em dia</option>
                <option value="pendente" @selected($status === 'pendente')>Pendente</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-parreiral stat-card">
                <div class="card-body">
                    <p class="stat-label mb-1">Total de clientes</p>
                    <p class="stat-value mb-0">{{ $totalClientes }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-parreiral-vine stat-card">
                <div class="card-body">
                    <p class="stat-label mb-1">Em dia</p>
                    <p class="stat-value mb-0 text-success">{{ $clientesEmDia }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-parreiral-gold stat-card">
                <div class="card-body">
                    <p class="stat-label mb-1">Pendentes</p>
                    <p class="stat-value mb-0" style="color: var(--wine-600);">{{ $clientesPendentes }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th><th>Identificador único</th><th>Nome</th><th>E-mail</th>
                    <th>Status financeiro</th><th>Qtd. compras</th><th>Total em compras</th><th>Cadastro</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>
                            @if($cliente->identificador)
                                <span class="badge rounded-pill" style="background: var(--wine-600);">{{ $cliente->identificador->codigo_externo }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ ucfirst($cliente->status_financeiro ?? '—') }}</td>
                        <td>{{ $cliente->compras_count }}</td>
                        <td>R$ {{ number_format($cliente->compras_sum_valor_total ?? 0, 2, ',', '.') }}</td>
                        <td>{{ $cliente->data_cadastro ? \Carbon\Carbon::parse($cliente->data_cadastro)->format('d/m/Y') : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Nenhum cliente encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection