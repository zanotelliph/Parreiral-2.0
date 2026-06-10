@extends('main')
@section('titulo', 'Compra de Produto')
@section('conteudo')
<<<<<<< HEAD
<h3>{{ isset($compraProduto) ? 'Editar compra' : 'Nova compra' }}</h3>
<form method="POST"
      action="{{ isset($compraProduto)
        ? route('compras-produtos.update', ['compras_produto' => $compraProduto->id])
        : route('compras-produtos.store') }}">
  @csrf
    @isset($compraProduto)
        @method('PUT')
    @endisset
    <div class="mb-3">
       <div class="mb-3">
    <label>Produto (ID)</label>
    <input type="number" class="form-control" name="produto_id" required
           value="{{ old('produto_id', $compraProduto->produto_id ?? '') }}">
</div>

<div class="mb-3">
    <label>Item da compra</label>
    <input type="text" class="form-control" name="item_compra" required
           value="{{ old('item_compra', $compraProduto->item_compra ?? '') }}">
</div>

<div class="mb-3">
    <label>Descrição</label>
    <textarea class="form-control" name="descricao">{{ old('descricao', $compraProduto->descricao ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Custo da compra (R$)</label>
    <input type="number" step="0.01" min="0" class="form-control" name="custo_compra" required
           value="{{ old('custo_compra', $compraProduto->custo_compra ?? 0) }}">
</div>

<div class="mb-3">
    <label>Desconto (R$)</label>
    <input type="number" step="0.01" min="0" class="form-control" name="desconto"
           value="{{ old('desconto', $compraProduto->desconto ?? 0) }}">
</div>

<div class="mb-3">
    <label>Parcelas</label>
    <input type="number" min="1" class="form-control" name="parcelas" required
           value="{{ old('parcelas', $compraProduto->parcelas ?? 1) }}">
</div>

<div class="mb-3">
    <label>Forma de pagamento</label>
    <input type="text" class="form-control" name="forma_pagamento" required
           value="{{ old('forma_pagamento', $compraProduto->forma_pagamento ?? '') }}">
</div>

<div class="mb-3">
    <label>Valor total (R$)</label>
    <input type="number" step="0.01" min="0" class="form-control" name="valor_total" required
           value="{{ old('valor_total', $compraProduto->valor_total ?? 0) }}">
</div>

<div class="mb-3">
    <label>Data da compra</label>
    <input type="date" class="form-control" name="data_compra" required
           value="{{ old('data_compra', $compraProduto->data_compra ?? date('Y-m-d')) }}">
</div>

<button class="btn btn-success">Salvar</button>
<a class="btn btn-secondary" href="{{ route('compras-produtos.index') }}">Voltar</a>
</form>

            
            
=======

@include('partials.page-header', [
    'title' => isset($compraProduto) ? 'Editar compra' : 'Nova compra',
    'subtitle' => 'Registre movimentações de produtos da vinícola',
])

<div class="content-panel">
<form method="POST" action="{{ isset($compraProduto) ? route('compras-produtos.update', $compraProduto) : route('compras-produtos.store') }}">
  @csrf
  @if(isset($compraProduto)) @method('PUT') @endif
  <div class="mb-3">
    <label class="form-label">Cliente</label>
    <select name="cliente_id" class="form-select" required>
      <option value="">Selecione o cliente</option>
      @foreach($clientes as $cliente)
        <option value="{{ $cliente->id }}" @selected(old('cliente_id', $compraProduto->cliente_id ?? '') == $cliente->id)>{{ $cliente->nome }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Produto</label>
    <select name="produto_id" class="form-select" required>
      <option value="">Selecione o produto</option>
      @foreach($produtos as $produto)
        <option value="{{ $produto->id }}" @selected(old('produto_id', $compraProduto->produto_id ?? '') == $produto->id)>{{ $produto->nome }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3"><label class="form-label">Fornecedor</label><input class="form-control" name="fornecedor" value="{{ old('fornecedor', $compraProduto->fornecedor ?? '') }}" required></div>
  <div class="mb-3"><label class="form-label">Quantidade</label><input type="number" class="form-control" name="quantidade" value="{{ old('quantidade', $compraProduto->quantidade ?? 1) }}" required></div>
  <div class="mb-3"><label class="form-label">Valor total</label><input type="number" step="0.01" class="form-control" name="valor_total" value="{{ old('valor_total', $compraProduto->valor_total ?? 0) }}" required></div>
  <div class="mb-3"><label class="form-label">Data da compra</label><input type="date" class="form-control" name="data_compra" value="{{ old('data_compra', isset($compraProduto) ? $compraProduto->data_compra?->format('Y-m-d') : date('Y-m-d')) }}" required></div>
  <div class="mb-3"><label class="form-label">Observação</label><textarea class="form-control" name="observacao">{{ old('observacao', $compraProduto->observacao ?? '') }}</textarea></div>
  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('compras-produtos.index') }}">Voltar</a>
</form>
</div>
@endsection
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2
