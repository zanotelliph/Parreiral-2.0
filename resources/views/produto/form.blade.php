@extends('main')
@section('titulo', 'Cadastro de Produto')

@section('conteudo')
@include('partials.page-header', [
    'title' => !empty($dado->id) ? 'Editar produto' : 'Novo produto',
    'subtitle' => 'Cadastre vinhos e derivados do parreiral',
])

<div class="content-panel">
@php
    $action = !empty($dado->id) ? route('produto.update', $dado->id) : route('produto.store');
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(!empty($dado->id))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-4">
            @include('partials.campo-imagem', [
                'imagemAtual' => $dado->imagem ?? null,
                'previewId' => 'preview-produto',
                'label' => 'Foto do produto',
            ])
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label class="form-label">Nome do produto</label>
                <input class="form-control" name="nome" value="{{ old('nome', $dado->nome ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria do produto</label>
                <input class="form-control" name="categoria_produto" value="{{ old('categoria_produto', $dado->categoria_produto ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de uva</label>
                <input class="form-control" name="tipo_uva" value="{{ old('tipo_uva', $dado->tipo_uva ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Lote do produto</label>
                <input class="form-control" name="lote_produto" value="{{ old('lote_produto', $dado->lote_produto ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Preço do produto</label>
                <input type="number" step="0.01" class="form-control" name="preco_produto" value="{{ old('preco_produto', $dado->preco_produto ?? $dado->preco ?? 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Desconto quando em promoção (%)</label>
                <input type="number" step="0.01" class="form-control" name="desconto_promocao" value="{{ old('desconto_promocao', $dado->desconto_promocao ?? 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao">{{ old('descricao', $dado->descricao ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantidade disponível</label>
                <input type="number" class="form-control" name="quantidade_disp" value="{{ old('quantidade_disp', $dado->quantidade_disp ?? 0) }}">
            </div>
        </div>
    </div>

    <button class="btn btn-success">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('produto.index') }}">Voltar</a>
</form>
</div>
@endsection
