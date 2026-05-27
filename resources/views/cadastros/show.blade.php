@extends('layouts.app')
@section('title', 'Cliente: ' . $cadastro->nome)

@section('content')
@php $breadcrumb = 'Cadastros / Clientes'; $pageTitle = 'Detalhes'; @endphp

<div class="page-header">
    <div>
        <h2>{{ $cadastro->nome }}</h2>
        <p>Cadastrado em {{ $cadastro->created_at->format('d/m/Y \à\s H:i') }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('cadastros.edit', $cadastro) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('cadastros.index') }}" class="btn btn-secondary">← Voltar</a>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; max-width:960px;">

    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header"><span class="card-title">Dados Pessoais</span></div>
            <div class="card-body">
                <table style="width:100%; font-size:.875rem;">
                    <tr><th style="text-align:left;padding:8px 0;color:var(--muted);width:40%;font-weight:600;">Nome</th><td>{{ $cadastro->nome }}</td></tr>
                    <tr><th style="text-align:left;padding:8px 0;color:var(--muted);font-weight:600;">E-mail</th><td>{{ $cadastro->email }}</td></tr>
                    <tr><th style="text-align:left;padding:8px 0;color:var(--muted);font-weight:600;">Telefone</th><td>{{ $cadastro->telefone ?? '—' }}</td></tr>
                    <tr><th style="text-align:left;padding:8px 0;color:var(--muted);font-weight:600;">CPF/CNPJ</th><td>{{ $cadastro->documento ?? '—' }}</td></tr>
                    <tr><th style="text-align:left;padding:8px 0;color:var(--muted);font-weight:600;">Nascimento</th><td>{{ $cadastro->data_nascimento?->format('d/m/Y') ?? '—' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Endereço</span></div>
            <div class="card-body">
                @if($cadastro->logradouro)
                    <p>{{ $cadastro->logradouro }}, {{ $cadastro->numero }}
                       @if($cadastro->complemento) — {{ $cadastro->complemento }} @endif
                    </p>
                    <p style="color:var(--muted); margin-top:4px;">
                        {{ $cadastro->bairro }} · {{ $cadastro->cidade }}/{{ $cadastro->estado }} · CEP {{ $cadastro->cep }}
                    </p>
                @else
                    <p style="color:var(--muted)">Endereço não informado.</p>
                @endif
            </div>
        </div>

        @if($cadastro->observacoes)
        <div class="card">
            <div class="card-header"><span class="card-title">Observações</span></div>
            <div class="card-body">
                <p style="color:var(--muted); line-height:1.6">{{ $cadastro->observacoes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header"><span class="card-title">Status</span></div>
            <div class="card-body">
                <span class="badge {{ $cadastro->ativo ? 'badge-success' : 'badge-danger' }}" style="font-size:.85rem;padding:5px 12px;">
                    {{ $cadastro->ativo ? '● Ativo' : '● Inativo' }}
                </span>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Ações</span></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                <a href="{{ route('cadastros.edit', $cadastro) }}" class="btn btn-primary" style="justify-content:center;">
                    Editar Dados
                </a>
                <form method="POST" action="{{ route('cadastros.destroy', $cadastro) }}"
                      x-data @submit.prevent="if(confirm('Excluir este cliente permanentemente?')) $el.submit()">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">
                        Excluir Cliente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
