@extends('layouts.app')
@section('title', isset($controle) ? 'Editar Movimentação' : 'Nova Movimentação')

@section('content')
@php
    $editing    = isset($controle);
    $breadcrumb = 'Controle / Movimentações';
    $pageTitle  = $editing ? 'Editar Movimentação' : 'Nova Movimentação';
@endphp

<div class="page-header">
    <div>
        <h2>{{ $editing ? 'Editar' : 'Nova' }} Movimentação</h2>
        <p>{{ $editing ? 'Atualize os dados da movimentação' : 'Registre uma nova entrada ou saída' }}</p>
    </div>
    <a href="{{ route('controles.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div style="max-width:720px;">
    <form method="POST"
          action="{{ $editing ? route('controles.update', $controle) : route('controles.store') }}">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><span class="card-title">Dados da Movimentação</span></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="descricao">Descrição *</label>
                        <input type="text" id="descricao" name="descricao"
                               value="{{ old('descricao', $controle->descricao ?? '') }}"
                               placeholder="Descreva a movimentação..." required />
                        @error('descricao') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo *</label>
                        <select id="tipo" name="tipo" required>
                            <option value="">Selecione</option>
                            <option value="entrada" {{ old('tipo', $controle->tipo ?? '') === 'entrada' ? 'selected' : '' }}>↑ Entrada</option>
                            <option value="saida"   {{ old('tipo', $controle->tipo ?? '') === 'saida'   ? 'selected' : '' }}>↓ Saída</option>
                        </select>
                        @error('tipo') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor (R$) *</label>
                        <input type="number" id="valor" name="valor" step="0.01" min="0"
                               value="{{ old('valor', $controle->valor ?? '') }}"
                               placeholder="0,00" required />
                        @error('valor') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="cadastro_id">Cliente</label>
                        <select id="cadastro_id" name="cadastro_id">
                            <option value="">Nenhum</option>
                            @foreach($clientes ?? [] as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('cadastro_id', $controle->cadastro_id ?? '') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }}
                            </option>
                            @endforeach
                        </select>
                        @error('cadastro_id') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="pendente"  {{ old('status', $controle->status ?? 'pendente') === 'pendente'  ? 'selected' : '' }}>Pendente</option>
                            <option value="concluido" {{ old('status', $controle->status ?? '') === 'concluido' ? 'selected' : '' }}>Concluído</option>
                            <option value="cancelado" {{ old('status', $controle->status ?? '') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('status') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group full">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes"
                                  placeholder="Informações adicionais...">{{ old('observacoes', $controle->observacoes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $editing ? 'Salvar Alterações' : 'Registrar Movimentação' }}
            </button>
            <a href="{{ route('controles.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
