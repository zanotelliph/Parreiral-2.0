@extends('main')
@section('titulo', 'Compra de Produto')
@section('conteudo')
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

            
            