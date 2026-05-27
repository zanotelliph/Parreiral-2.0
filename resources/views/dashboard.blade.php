@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    $breadcrumb = 'Sistema';
    $pageTitle  = 'Dashboard';
@endphp

<div class="page-header">
    <div>
        <h2>Dashboard</h2>
        <p>Visão geral do sistema &mdash; {{ now()->format('d/m/Y') }}</p>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Clientes</div>
        <div class="stat-value">{{ $totalClientes ?? 0 }}</div>
        <div class="stat-delta">↑ 12% este mês</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">Produtos</div>
        <div class="stat-value">{{ $totalProdutos ?? 0 }}</div>
        <div class="stat-delta">↑ 5% este mês</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Movimentações</div>
        <div class="stat-value">{{ $totalMovimentacoes ?? 0 }}</div>
        <div class="stat-delta">↑ 8% este mês</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-label">Pendentes</div>
        <div class="stat-value">{{ $totalPendentes ?? 0 }}</div>
        <div class="stat-delta down">↓ 3% este mês</div>
    </div>
</div>

{{-- Charts row --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:16px; margin-bottom:24px;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">Movimentações por Mês</span>
        </div>
        <div class="card-body">
            <canvas id="chartMovimentacoes" height="100"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Status</span>
        </div>
        <div class="card-body">
            <canvas id="chartStatus" height="180"></canvas>
        </div>
    </div>
</div>

{{-- Recent tables --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">Últimos Clientes</span>
            <a href="{{ route('cadastros.index') }}" class="btn btn-ghost" style="font-size:.8rem;">Ver todos →</a>
        </div>
        <div class="card-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosClientes ?? [] as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td style="color:var(--muted)">{{ $cliente->email }}</td>
                            <td>
                                <span class="badge {{ $cliente->ativo ? 'badge-success' : 'badge-danger' }}">
                                    {{ $cliente->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="color:var(--muted);text-align:center">Nenhum registro</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Últimas Movimentações</span>
            <a href="{{ route('controles.index') }}" class="btn btn-ghost" style="font-size:.8rem;">Ver todas →</a>
        </div>
        <div class="card-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasMovimentacoes ?? [] as $mov)
                        <tr>
                            <td>{{ $mov->descricao }}</td>
                            <td>
                                <span class="badge {{ $mov->tipo === 'entrada' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($mov->tipo) }}
                                </span>
                            </td>
                            <td style="color:var(--muted)">{{ $mov->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="color:var(--muted);text-align:center">Nenhum registro</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const accent  = '#C84B2F';
    const accent2 = '#2F6FC8';
    const muted   = '#E2DDD5';

    // Line chart
    new Chart(document.getElementById('chartMovimentacoes'), {
        type: 'line',
        data: {
            labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            datasets: [{
                label: 'Entradas',
                data: {{ json_encode($dadosMensaisEntrada ?? [12,18,14,22,19,28,25,30,22,27,33,29]) }},
                borderColor: accent2,
                backgroundColor: accent2 + '22',
                tension: .4, fill: true, pointRadius: 3,
            },{
                label: 'Saídas',
                data: {{ json_encode($dadosMensaisSaida ?? [8,12,10,15,13,18,16,20,15,19,22,18]) }},
                borderColor: accent,
                backgroundColor: accent + '22',
                tension: .4, fill: true, pointRadius: 3,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { grid: { color: muted } }, x: { grid: { display: false } } }
        }
    });

    // Doughnut chart
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Ativos','Inativos','Pendentes'],
            datasets: [{ data: [63, 15, 22], backgroundColor: ['#2A7D4F','#C84B2F','#B87A1A'], borderWidth: 0 }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>
@endpush

@endsection
