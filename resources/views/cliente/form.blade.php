@extends('main')
@section('titulo', 'Formulário cliente')
@section('conteudo')

@include('partials.page-header', [
    'title' => !empty($dado->id) ? 'Editar cliente' : 'Novo cliente',
    'subtitle' => 'Cadastro de clientes da vinícola',
])

<div class="content-panel">

    @php
        if (!empty($dado->id)) {
            $action = route('cliente.update', $dado->id);
        } else {
            $action = route('cliente.store');
        }
    @endphp

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (!empty($dado->id))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Tipo de documento</label>
                <select class="form-select" name="tipo_documento">
                    <option value="cpf" @selected(old('tipo_documento', optional($dado ?? null)->identificador?->tipo_documento ?? 'cpf') === 'cpf')>CPF</option>
                    <option value="rg" @selected(old('tipo_documento', optional($dado ?? null)->identificador?->tipo_documento) === 'rg')>RG</option>
                    <option value="outro" @selected(old('tipo_documento', optional($dado ?? null)->identificador?->tipo_documento) === 'outro')>Outro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Documento</label>
                <input type="text" class="form-control" name="documento"
                    value="{{ old('documento', optional($dado ?? null)->identificador?->documento ?? optional($dado ?? null)->cpf) }}">
            </div>
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" value="{{ old('nome', $dado->nome ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento', $dado->data_nascimento ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $dado->email ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="telefone" value="{{ old('telefone', $dado->telefone ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">CEP</label>
                <input type="text" class="form-control" name="cep" value="{{ old('cep', $dado->cep ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Data de Cadastro</label>
                <input type="date" class="form-control" name="data_cadastro" value="{{ old('data_cadastro', $dado->data_cadastro ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status Financeiro</label>
                <select class="form-select" name="status_financeiro">
                    <option value="em dia" {{ old('status_financeiro', $dado->status_financeiro ?? 'em dia') == 'em dia' ? 'selected' : '' }}>Em dia</option>
                    <option value="pendente" {{ old('status_financeiro', $dado->status_financeiro ?? 'em dia') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                </select>
            </div>
                    {{-- ENDEREÇO --}}
        <div class="row">
            <div class="col">
                <label class="form-label">CEP</label>
                <input type="text" class="form-control" name="cep"
                    value="{{ old('cep', $dado->endereco->cep ?? '') }}">
                </div>

                <div class="col">
                    <label class="form-label">Rua / Avenida</label>
                    <input type="text" class="form-control" name="rua"
                        value="{{ old('rua', $dado->endereco->rua ?? '') }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label">Número</label>
                    <input type="text" class="form-control" name="numero"
                        value="{{ old('numero', $dado->endereco->numero ?? '') }}">
                </div>
                <div class="col">
                    <label class="form-label">Complemento</label>
                    <input type="text" class="form-control" name="complemento"
                        value="{{ old('complemento', $dado->endereco->complemento ?? '') }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label">Bairro</label>
                    <input type="text" class="form-control" name="bairro"
                        value="{{ old('bairro', $dado->endereco->bairro ?? '') }}">
                </div>
                <div class="col">
                    <label class="form-label">Cidade</label>
                    <input type="text" class="form-control" name="cidade"
                        value="{{ old('cidade', $dado->endereco->cidade ?? '') }}">
                </div>
                <div class="col">
                    <label class="form-label">Estado</label>
                    <select class="form-control" name="estado">
                    <option value="">Selecione</option>
                        <option value="AC" {{ old('estado', $dado->endereco->estado ?? '') == 'AC' ? 'selected' : '' }}>Acre</option>
                        <option value="AL" {{ old('estado', $dado->endereco->estado ?? '') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                        <option value="AP" {{ old('estado', $dado->endereco->estado ?? '') == 'AP' ? 'selected' : '' }}>Amapá</option>
                        <option value="AM" {{ old('estado', $dado->endereco->estado ?? '') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                        <option value="BA" {{ old('estado', $dado->endereco->estado ?? '') == 'BA' ? 'selected' : '' }}>Bahia</option>
                        <option value="CE" {{ old('estado', $dado->endereco->estado ?? '') == 'CE' ? 'selected' : '' }}>Ceará</option>
                        <option value="DF" {{ old('estado', $dado->endereco->estado ?? '') == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                        <option value="ES" {{ old('estado', $dado->endereco->estado ?? '') == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                        <option value="GO" {{ old('estado', $dado->endereco->estado ?? '') == 'GO' ? 'selected' : '' }}>Goiás</option>
                        <option value="MA" {{ old('estado', $dado->endereco->estado ?? '') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                        <option value="MT" {{ old('estado', $dado->endereco->estado ?? '') == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                        <option value="MS" {{ old('estado', $dado->endereco->estado ?? '') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                        <option value="MG" {{ old('estado', $dado->endereco->estado ?? '') == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                        <option value="PA" {{ old('estado', $dado->endereco->estado ?? '') == 'PA' ? 'selected' : '' }}>Pará</option>
                        <option value="PB" {{ old('estado', $dado->endereco->estado ?? '') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                        <option value="PR" {{ old('estado', $dado->endereco->estado ?? '') == 'PR' ? 'selected' : '' }}>Paraná</option>
                        <option value="PE" {{ old('estado', $dado->endereco->estado ?? '') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                        <option value="PI" {{ old('estado', $dado->endereco->estado ?? '') == 'PI' ? 'selected' : '' }}>Piauí</option>
                        <option value="RJ" {{ old('estado', $dado->endereco->estado ?? '') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                        <option value="RN" {{ old('estado', $dado->endereco->estado ?? '') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                        <option value="RS" {{ old('estado', $dado->endereco->estado ?? '') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                        <option value="RO" {{ old('estado', $dado->endereco->estado ?? '') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                        <option value="RR" {{ old('estado', $dado->endereco->estado ?? '') == 'RR' ? 'selected' : '' }}>Roraima</option>
                        <option value="SC" {{ old('estado', $dado->endereco->estado ?? '') == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                        <option value="SP" {{ old('estado', $dado->endereco->estado ?? '') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                        <option value="SE" {{ old('estado', $dado->endereco->estado ?? '') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                        <option value="TO" {{ old('estado', $dado->endereco->estado ?? '') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                    </select>
                </div>
            </div>
            {{-- Preferências --}}
            <div class="row">

                <div class="col">
                    <label class="form-label">Preferências de Compra </label>
                    <input type="text" class="form-control" name="preferenciadecompra"
                        value="{{ old('preferenciadecompra', $dado->historico->preferenciadecompra ?? '') }}">
                </div>

                <div class="col">
                    <label class="form-label">Observações</label>
                    <input type="text" class="form-control" name="observacoes"
                        value="{{ old('observacoes', $dado->historico->observacoes ?? '') }}">
                </div>
                <div class="col">
                    <label class="form-label">Número de visitas</label>
                    <input type="number" class="form-control" name="numero_visitas"
                        value="{{ old('numero_visitas', $dado->endereco->numero_visitas ?? 0) }}" min="0">
                </div>
                <div class="col">
                    <label class="form-label">Data da ùltima Visita</label>
                    <input type="date" class="form-control" name="data_ultima_visita"
                        value="{{ old('data_ultima_visita', isset($dado->endereco->data_ultima_visita) ? \Carbon\Carbon::parse($dado->endereco->data_ultima_visita)->format('Y-m-d') : '') }}">
                </div>
                <div class="col">
                    <label class="form-label">Cliente fidelizado</label>
                    <select class="form-select" name="cliente_fidelizado">
                        <option value="0" {{ old('cliente_fidelizado', $dado->endereco->cliente_fidelizado ?? 0) == 0 ? 'selected' : '' }}>
                            Não
                        </option>
                        <option value="1" {{ old('cliente_fidelizado', $dado->endereco->cliente_fidelizado ?? 0) == 1 ? 'selected' : '' }}>
                            Sim
                        </option>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Nível de Fidelidade</label>
                    <select class="form-select" name="nivel_fidelidade">
                        <option value="0" {{ old('nivel_fidelidade', $dado->endereco->nivel_fidelidade ?? 0) == 0 ? 'selected' : '' }}>
                            Bronze
                        </option>
                        <option value="1" {{ old('nivel_fidelidade', $dado->endereco->nivel_fidelidade ?? 0) == 1 ? 'selected' : '' }}>
                            Prata
                        </option>
                        <option value="2" {{ old('nivel_fidelidade', $dado->endereco->nivel_fidelidade ?? 0) == 2 ? 'selected' : '' }}>
                            Ouro
                        </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @include('partials.campo-imagem', [
                        'imagemAtual' => optional($dado ?? null)->imagem,
                        'previewId' => 'preview-cliente',
                        'label' => 'Foto do cliente',
                    ])
                </div>
            </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ url('cliente') }}" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </form>

</div>
@stop
