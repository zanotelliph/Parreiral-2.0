@extends('main')
@section('titulo', 'Formulário de Produto')
@section('conteudo')
<h3>{{ isset($produto) ? 'Editar produto' : 'Novo produto' }}</h3>
<form method="POST" action="{{ isset($produto) ? route('produto.update', $produto) : route('produto.store') }}">
  @csrf
  @if(isset($produto)) @method('PUT') @endif
  <div class="mb-3"><label>Nome do produto</label><input class="form-control" name="nome" value="{{ old('nome', $produto->nome ?? '') }}" required></div>
  <div class="mb-3"><label>Categoria do produto</label><input class="form-control" name="categoria_produto" value="{{ old('categoria_produto', $produto->categoria_produto ?? '') }}"></div>
  <div class="mb-3"><label>Tipo de uva</label><input class="form-control" name="tipo_uva" value="{{ old('tipo_uva', $produto->tipo_uva ?? '') }}"></div>
  <div class="mb-3"><label>Lote do produto</label><input class="form-control" name="lote_produto" value="{{ old('lote_produto', $produto->lote_produto ?? '') }}"></div>
  <div class="mb-3"><label>Preço do produto</label><input type="number" step="0.01" class="form-control" name="preco_produto" value="{{ old('preco_produto', $produto->preco_produto ?? $produto->preco ?? 0) }}"></div>
  <div class="mb-3"><label>Desconto quando em promoção (%)</label><input type="number" step="0.01" class="form-control" name="desconto_promocao" value="{{ old('desconto_promocao', $produto->desconto_promocao ?? 0) }}"></div>
  <div class="mb-3"><label>Descrição</label><textarea class="form-control" name="descricao">{{ old('descricao', $produto->descricao ?? '') }}</textarea></div>
  <div class="mb-3"><label>Quantidade disponível</label><input type="number" class="form-control" name="quantidade_disponivel" value="{{ old('quantidade_disponivel', $produto->quantidade_disponivel ?? 0) }}"></div>
  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('produto.index') }}">Voltar</a>
</form>
@endsection
