@extends('main')
@section('titulo', 'Formulário cliente')
@section('conteudo')

    <h4>Formulário cliente</h4>

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
        < class="row">
            <input type="hidden" name="id" value="{{ $dado->id ?? '' }}">
            <div class="col">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" value="{{ old('nome', $dado->nome ?? '') }}">
            </div>
            <div class="col">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="telefone"
                    value="{{ old('telefone', $dado->telefone ?? '') }}">
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
            <div class="col">
                <label class="form-label" for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" value="{{ old('cpf', $dado->cpf ?? '') }}">
            </div>
            <div class="col">
                <label class="form-label" for="cpf"></label>
                <input type="text" class="form-control" name="cpf" value="{{ old('cpf', $dado->cpf ?? '') }}">
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
        </div>
        <div class="row">
            <div class="col">
                <label class="form-label" for="imagem">Imagem</label>
                @php
                    $nome_imagem = !empty($dado->imagem) ? $dado->imagem : 'sem_imagem.png';
                @endphp
                <img src="/storage/{{ $nome_imagem }}" class="rounded-circle" width="200px" height="200px" alt="imagem">
                <input type="file" name="imagem" class="form-control" value="{{ old('imagem', $dado->imagem ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ url('cliente') }}" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </form>

@stop
