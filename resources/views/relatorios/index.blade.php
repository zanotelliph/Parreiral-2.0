@extends('layouts.app')
@section('title', 'Relatórios')

@section('content')
@php $breadcrumb = 'Controle'; $pageTitle = 'Relatórios'; @endphp

<div class="page-header">
    <div>
        <h2>Relatórios</h2>
        <p>Análise e exportação de dados do sistema</p>
    </div>
</div>

{{-- Filtro período --}}
<div class="card" style="margin-bottom:24px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" action="{{ route('relatorios.index') }}"
              style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            <div class="form-group" style="min-width:160px;">
                <label>Período inicial</label>
                <input type="date" name="inicio" value="{{ request('inicio', now()->startOfMonth()->format('Y-m-d')) }}" />
            </div>
            <div class="form-group" style="min-width:160px;">
                <label>Período final</label>
                <input type="date" name="fim" value="{{ request('fim', now()->format('Y-m-d')) }}" />
            </div>
            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
            <a href="{{ route('relatorios.exportar') }}?{{ http_build_query(request()->all()) }}"
               class="btn btn-secondary">
                ↓ Exportar CSV
            </a>
        </form>
    </div>
</div>

{{-- Stats do período --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card green">
        <div class="stat-label">Entradas no Período</div>
        <div class="stat-value" style="font-size:1.4rem;">R$ {{ number_format($entradas ?? 0, 2, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Saídas no Período</div>
        <div class="stat-value" style="font-size:1.4rem;">R$ {{ number_format($saidas ?? 0, 2, ',', '.') }}</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">Saldo do Período</div>
        <div class="stat-value" style="font-size:1.4rem;">R$ {{ number_format(($entradas ?? 0) - ($saidas ?? 0), 2, ',', '.') }}</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-label">Novos Clientes</div>
        <div class="stat-value">{{ $novosClientes ?? 0 }}</div>
    </div>
</div>

{{-- Gráficos --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
    <div class="card">
        <div class="card-header"><span class="card-title">Entradas vs Saídas</span></div>
        <div class="card-body"><canvas id="chartComparativo" height="120"></canvas></div>
    </div>
    <div class="card">
        <div class="card-header"><span class="card-title">Clientes por Estado</span></div>
        <div class="card-body"><canvas id="chartEstados" height="120"></canvas></div>
    </div>
</div>

{{-- Tabela detalhada --}}
<div class="card">
    <div class="card-header" style="padding:20px 24px 16px;">
        <span class="card-title">Movimentações do Período</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th style="text-align:right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimentacoes ?? [] as $m)
                <tr>
                    <td style="color:var(--muted)">{{ $m->created_at->format('d/m/Y') }}</td>
                    <td>{{ $m->descricao }}</td>
                    <td style="color:var(--muted)">{{ $m->cadastro->nome ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $m->tipo === 'entrada' ? 'badge-success' : 'badge-danger' }}">
                            {{ $m->tipo === 'entrada' ? '↑ Entrada' : '↓ Saída' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $m->status === 'concluido' ? 'badge-success' : ($m->status === 'cancelado' ? 'badge-danger' : 'badge-warning') }}">
                            {{ ucfirst($m->status) }}
                        </span>
                    </td>
                    <td style="text-align:right; font-weight:600; font-variant-numeric:tabular-nums;">
                        R$ {{ number_format($m->valor, 2, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">Nenhuma movimentação no período.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<script>
document.addEventListener('DOMContentLoaded', () => {
    new Chart(document.getElementById('chartComparativo'), {
        type: 'bar',
        data: {
            labels: {{ json_encode($labels ?? ['Sem 1','Sem 2','Sem 3','Sem 4']) }},
            datasets: [
                { label: 'Entradas', data: {{ json_encode($dadosEntrada ?? [1200,980,1400,1100]) }}, backgroundColor: '#2A7D4F' },
                { label: 'Saídas',   data: {{ json_encode($dadosSaida   ?? [800, 650, 900, 750]) }},  backgroundColor: '#C84B2F' },
            ]
        },
        options: { responsive:true, plugins:{ legend:{ position:'bottom' } } }
    });

    new Chart(document.getElementById('chartEstados'), {
        type: 'bar',
        indexAxis: 'y',
        data: {
            labels: {{ json_encode($estadosLabels ?? ['SC','PR','RS','SP','MG']) }},
            datasets: [{ label: 'Clientes', data: {{ json_encode($estadosData ?? [42,18,15,12,8]) }}, backgroundColor: '#2F6FC8' }]
        },
        options: { responsive:true, plugins:{ legend:{ display:false } } }
    });
});
</script>
@endpush
@endsection
