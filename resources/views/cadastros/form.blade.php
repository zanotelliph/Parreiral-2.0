@extends('layouts.app')
@section('title', isset($cadastro) ? 'Editar Cliente' : 'Novo Cliente')

@section('content')
@php
    $editing     = isset($cadastro);
    $breadcrumb  = 'Cadastros / Clientes';
    $pageTitle   = $editing ? 'Editar Cliente' : 'Novo Cliente';
@endphp

<div class="page-header">
    <div>
        <h2>{{ $editing ? 'Editar' : 'Novo' }} Cliente</h2>
        <p>{{ $editing ? 'Atualize os dados do cliente' : 'Preencha os dados para cadastrar um novo cliente' }}</p>
    </div>
    <a href="{{ route('cadastros.index') }}" class="btn btn-secondary">
        ← Voltar
    </a>
</div>

<div style="max-width:820px;">
    <form method="POST"
          action="{{ $editing ? route('cadastros.update', $cadastro) : route('cadastros.store') }}">
        @csrf
        @if($editing) @method('PUT') @endif

        {{-- Dados pessoais --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <span class="card-title">Dados Pessoais</span>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="nome">Nome completo *</label>
                        <input type="text" id="nome" name="nome"
                               value="{{ old('nome', $cadastro->nome ?? '') }}"
                               placeholder="Ex.: João da Silva" required />
                        @error('nome') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $cadastro->email ?? '') }}"
                               placeholder="joao@email.com" required />
                        @error('email') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone"
                               value="{{ old('telefone', $cadastro->telefone ?? '') }}"
                               placeholder="(49) 99999-9999" />
                        @error('telefone') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="documento">CPF / CNPJ</label>
                        <input type="text" id="documento" name="documento"
                               value="{{ old('documento', $cadastro->documento ?? '') }}"
                               placeholder="000.000.000-00" />
                        @error('documento') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" id="data_nascimento" name="data_nascimento"
                               value="{{ old('data_nascimento', isset($cadastro) ? $cadastro->data_nascimento?->format('Y-m-d') : '') }}" />
                        @error('data_nascimento') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <span class="card-title">Endereço</span>
            </div>
            <div class="card-body">
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep"
                               value="{{ old('cep', $cadastro->cep ?? '') }}"
                               placeholder="89800-000" />
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro"
                               value="{{ old('logradouro', $cadastro->logradouro ?? '') }}"
                               placeholder="Rua, Avenida..." />
                    </div>
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="numero"
                               value="{{ old('numero', $cadastro->numero ?? '') }}"
                               placeholder="123" />
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento"
                               value="{{ old('complemento', $cadastro->complemento ?? '') }}"
                               placeholder="Apto, Sala..." />
                    </div>
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro"
                               value="{{ old('bairro', $cadastro->bairro ?? '') }}" />
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade"
                               value="{{ old('cidade', $cadastro->cidade ?? '') }}" />
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado">
                            <option value="">Selecione</option>
                            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                            <option value="{{ $uf }}"
                                {{ old('estado', $cadastro->estado ?? '') === $uf ? 'selected' : '' }}>
                                {{ $uf }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Configurações --}}
        <div class="card" style="margin-bottom:24px;">
            <div class="card-header">
                <span class="card-title">Configurações</span>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="ativo" required>
                            <option value="1" {{ old('ativo', $cadastro->ativo ?? 1) == 1 ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('ativo', $cadastro->ativo ?? 1) == 0 ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes"
                                  placeholder="Informações adicionais...">{{ old('observacoes', $cadastro->observacoes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Cliente' }}
            </button>
            <a href="{{ route('cadastros.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
