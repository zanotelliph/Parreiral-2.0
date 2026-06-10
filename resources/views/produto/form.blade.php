@extends('main')
@section('titulo', 'Cadastro de Produto')

@section('conteudo')

<h4>Cadastro de Produto</h4>

@php
if (!empty($dado->id)) {
$action = route('produto.update', $dado->id);
} else {
$action = route('produto.store');
}
@endphp

<form action="{{ $action }}" method="POST">

```
@csrf

@if(!empty($dado->id))
    @method('PUT')
@endif

<input type="hidden" name="id" value="{{ $dado->id ?? '' }}">

<div class="row mb-3">

    <div class="col-md-6">
        <label class="form-label">Nome</label>
        <input type="text"
               name="nome"
               class="form-control"
               value="{{ old('nome', $dado->nome ?? '') }}"
               required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Categoria</label>
        <input type="text"
               name="categoria_produto"
               class="form-control"
               value="{{ old('categoria_produto', $dado->categoria_produto ?? '') }}">
    </div>

</div>

<div class="row mb-3">

    <div class="col-md-4">
        <label class="form-label">Tipo de Uva</label>
        <input type="text"
               name="tipo_uva"
               class="form-control"
               value="{{ old('tipo_uva', $dado->tipo_uva ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Lote</label>
        <input type="text"
               name="lote"
               class="form-control"
               value="{{ old('lote', $dado->lote ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Lote Produto</label>
        <input type="text"
               name="lote_produto"
               class="form-control"
               value="{{ old('lote_produto', $dado->lote_produto ?? '') }}">
    </div>

</div>

<div class="row mb-3">

    <div class="col-md-3">
        <label class="form-label">Preço</label>
        <input type="number"
               step="0.01"
               name="preco"
               class="form-control"
               value="{{ old('preco', $dado->preco ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Preço Produto</label>
        <input type="number"
               step="0.01"
               name="preco_produto"
               class="form-control"
               value="{{ old('preco_produto', $dado->preco_produto ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Desconto (%)</label>
        <input type="number"
               step="0.01"
               name="desconto_promocao"
               class="form-control"
               value="{{ old('desconto_promocao', $dado->desconto_promocao ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Quantidade Disponível</label>
        <input type="number"
               name="quantidade_disponivel"
               class="form-control"
               value="{{ old('quantidade_disponivel', $dado->quantidade_disponivel ?? '') }}">
    </div>

</div>

<div class="row mb-3">

    <div class="col">
        <label class="form-label">Descrição</label>
        <textarea name="descricao"
                  class="form-control"
                  rows="4">{{ old('descricao', $dado->descricao ?? '') }}</textarea>
    </div>

</div>

<div class="row">
    <div class="col">

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('produto.index') }}"
           class="btn btn-primary">
            Voltar
        </a>

    </div>
</div>
```

</form>

@endsection
