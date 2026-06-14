@extends('main')
@section('titulo', 'Compra de Produto')
@section('conteudo')

@include('partials.page-header', [
    'title' => isset($compraProduto) ? 'Editar compra' : 'Nova compra',
    'subtitle' => 'Registre movimentações de produtos da vinícola',
])

<div class="content-panel">
<form method="POST" action="{{ isset($compraProduto) ? route('compras-produtos.update', ['compras_produto' => $compraProduto->id]) : route('compras-produtos.store') }}">
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
