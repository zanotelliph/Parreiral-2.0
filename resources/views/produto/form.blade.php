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


</form>

@include('partials.page-header', [
    'title' => isset($produto) ? 'Editar produto' : 'Novo produto',
    'subtitle' => 'Cadastre vinhos e derivados do parreiral',
])

<div class="content-panel">
<form method="POST" action="{{ isset($produto) ? route('produto.update', $produto) : route('produto.store') }}" enctype="multipart/form-data">
  @csrf
  @if(isset($produto)) @method('PUT') @endif

  <div class="row">
    <div class="col-md-4">
      @include('partials.campo-imagem', [
          'imagemAtual' => $produto->imagem ?? null,
          'previewId' => 'preview-produto',
          'label' => 'Foto do produto',
      ])
    </div>
    <div class="col-md-8">
      <div class="mb-3"><label class="form-label">Nome do produto</label><input class="form-control" name="nome" value="{{ old('nome', $produto->nome ?? '') }}" required></div>
      <div class="mb-3"><label class="form-label">Categoria do produto</label><input class="form-control" name="categoria_produto" value="{{ old('categoria_produto', $produto->categoria_produto ?? '') }}"></div>
      <div class="mb-3"><label class="form-label">Tipo de uva</label><input class="form-control" name="tipo_uva" value="{{ old('tipo_uva', $produto->tipo_uva ?? '') }}"></div>
      <div class="mb-3"><label class="form-label">Lote do produto</label><input class="form-control" name="lote_produto" value="{{ old('lote_produto', $produto->lote_produto ?? '') }}"></div>
      <div class="mb-3"><label class="form-label">Preço do produto</label><input type="number" step="0.01" class="form-control" name="preco_produto" value="{{ old('preco_produto', $produto->preco_produto ?? $produto->preco ?? 0) }}"></div>
      <div class="mb-3"><label class="form-label">Desconto quando em promoção (%)</label><input type="number" step="0.01" class="form-control" name="desconto_promocao" value="{{ old('desconto_promocao', $produto->desconto_promocao ?? 0) }}"></div>
      <div class="mb-3"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao">{{ old('descricao', $produto->descricao ?? '') }}</textarea></div>
      <div class="mb-3"><label class="form-label">Quantidade disponível</label><input type="number" class="form-control" name="quantidade_disponivel" value="{{ old('quantidade_disponivel', $produto->quantidade_disponivel ?? 0) }}"></div>
    </div>
  </div>

  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('produto.index') }}">Voltar</a>
</form>
</div>
 
@endsection
