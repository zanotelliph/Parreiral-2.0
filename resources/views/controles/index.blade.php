@extends('layouts.app')
@section('title', 'Movimentações')

@section('content')
@php $breadcrumb = 'Controle'; $pageTitle = 'Movimentações'; @endphp

<div class="page-header">
    <div>
        <h2>Movimentações</h2>
        <p>Controle de entradas e saídas do sistema</p>
    </div>
    <a href="{{ route('controles.create') }}" class="btn btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Nova Movimentação
    </a>
</div>

{{-- Filtros --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" action="{{ route('controles.index') }}"
              style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            <div class="form-group" style="flex:1; min-width:180px;">
                <label>Buscar</label>
                <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Descrição..." />
            </div>
            <div class="form-group" style="min-width:140px;">
                <label>Tipo</label>
                <select name="tipo">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('tipo') === 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="saida"   {{ request('tipo') === 'saida'   ? 'selected' : '' }}>Saída</option>
                </select>
            </div>
            <div class="form-group" style="min-width:150px;">
                <label>Data inicial</label>
                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" />
            </div>
            <div class="form-group" style="min-width:150px;">
                <label>Data final</label>
                <input type="date" name="data_fim" value="{{ request('data_fim') }}" />
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('controles.index') }}" class="btn btn-secondary">Limpar</a>
        </form>
    </div>
</div>

{{-- Resumo --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px;">
    <div class="stat-card green">
        <div class="stat-label">Total Entradas</div>
        <div class="stat-value" style="font-size:1.5rem;">
            R$ {{ number_format($totalEntradas ?? 0, 2, ',', '.') }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Saídas</div>
        <div class="stat-value" style="font-size:1.5rem;">
            R$ {{ number_format($totalSaidas ?? 0, 2, ',', '.') }}
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">Saldo</div>
        <div class="stat-value" style="font-size:1.5rem;">
            R$ {{ number_format(($totalEntradas ?? 0) - ($totalSaidas ?? 0), 2, ',', '.') }}
        </div>
    </div>
</div>

{{-- Tabela --}}
<div class="card">
    <div class="card-header" style="padding:20px 24px 16px;">
        <span class="card-title">Registros</span>
        <span style="font-size:.8rem; color:var(--muted)">{{ $controles->total() ?? 0 }} registro(s)</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th style="text-align:right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($controles as $c)
                <tr>
                    <td style="color:var(--muted)">{{ $c->id }}</td>
                    <td><strong>{{ $c->descricao }}</strong></td>
                    <td style="color:var(--muted)">{{ $c->cadastro->nome ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $c->tipo === 'entrada' ? 'badge-success' : 'badge-danger' }}">
                            {{ $c->tipo === 'entrada' ? '↑ Entrada' : '↓ Saída' }}
                        </span>
                    </td>
                    <td style="font-variant-numeric:tabular-nums; font-weight:600;">
                        R$ {{ number_format($c->valor, 2, ',', '.') }}
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'pendente'   => 'badge-warning',
                                'concluido'  => 'badge-success',
                                'cancelado'  => 'badge-danger',
                            ];
                        @endphp
                        <span class="badge {{ $statusMap[$c->status] ?? 'badge-info' }}">
                            {{ ucfirst($c->status) }}
                        </span>
                    </td>
                    <td style="color:var(--muted)">{{ $c->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('controles.edit', $c) }}" class="btn btn-secondary" style="padding:6px 10px;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('controles.destroy', $c) }}"
                                  x-data @submit.prevent="if(confirm('Excluir esta movimentação?')) $el.submit()">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:6px 10px;">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:40px; color:var(--muted);">
                        Nenhuma movimentação encontrada.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($controles) && $controles->hasPages())
    <div style="padding:16px 24px;">
        {{ $controles->withQueryString()->links('partials.pagination') }}
    </div>
    @endif
</div>
@endsection
