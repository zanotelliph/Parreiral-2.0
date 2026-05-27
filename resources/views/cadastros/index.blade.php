@extends('layouts.app')
@section('title', 'Clientes')

@section('content')
@php $breadcrumb = 'Cadastros'; $pageTitle = 'Clientes'; @endphp

<div class="page-header">
    <div>
        <h2>Clientes</h2>
        <p>Gerencie os clientes cadastrados no sistema</p>
    </div>
    <a href="{{ route('cadastros.create') }}" class="btn btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Novo Cliente
    </a>
</div>

{{-- Filtros --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" action="{{ route('cadastros.index') }}"
              style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            <div class="form-group" style="flex:1; min-width:200px;">
                <label>Buscar</label>
                <input type="text" name="busca" value="{{ request('busca') }}"
                       placeholder="Nome, e-mail ou documento..." />
            </div>
            <div class="form-group" style="min-width:150px;">
                <label>Status</label>
                <select name="status">
                    <option value="">Todos</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('cadastros.index') }}" class="btn btn-secondary">Limpar</a>
        </form>
    </div>
</div>

{{-- Tabela --}}
<div class="card">
    <div class="card-header" style="padding:20px 24px 16px;">
        <span class="card-title">Lista de Clientes</span>
        <span style="font-size:.8rem; color:var(--muted)">
            {{ $cadastros->total() ?? 0 }} registro(s)
        </span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>CPF / CNPJ</th>
                    <th>Status</th>
                    <th>Cadastro</th>
                    <th style="text-align:right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cadastros as $c)
                <tr>
                    <td style="color:var(--muted)">{{ $c->id }}</td>
                    <td><strong>{{ $c->nome }}</strong></td>
                    <td style="color:var(--muted)">{{ $c->email }}</td>
                    <td>{{ $c->telefone ?? '—' }}</td>
                    <td style="font-variant-numeric:tabular-nums">{{ $c->documento ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $c->ativo ? 'badge-success' : 'badge-danger' }}">
                            {{ $c->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td style="color:var(--muted)">{{ $c->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('cadastros.show', $c) }}" class="btn btn-secondary" style="padding:6px 10px;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('cadastros.edit', $c) }}" class="btn btn-secondary" style="padding:6px 10px;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('cadastros.destroy', $c) }}"
                                  x-data
                                  @submit.prevent="if(confirm('Excluir este cliente?')) $el.submit()">
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
                        Nenhum cliente encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($cadastros) && $cadastros->hasPages())
    <div style="padding:16px 24px;">
        {{ $cadastros->withQueryString()->links('partials.pagination') }}
    </div>
    @endif
</div>
@endsection
