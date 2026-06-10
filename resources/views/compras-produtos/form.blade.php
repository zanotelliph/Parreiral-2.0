@extends('main')
@section('titulo', 'Compra de Produto')
@section('conteudo')
<h3>{{ isset($compraProduto) ? 'Editar compra' : 'Nova compra' }}</h3>
<form method="POST" action="{{ isset($compraProduto) ? route('compras-produtos.update', $compraProduto) : route('compras-produtos.store') }}">
  @csrf
  @if(isset($compraProduto)) @method('PUT') @endif
  <div class="mb-3"><label>Produto (ID)</label><input type="number" class="form-control" name="produto_id" value="{{ old('produto_id', $compraProduto->produto_id ?? '') }}"></div>
  <div class="mb-3"><label>Fornecedor</label><input type="text" class="form-control" name="fornecedor" value="{{ old('fornecedor', $compraProduto->fornecedor ?? '') }}"></div>
  <div class="mb-3"><label>Quantidade</label><input type="number" class="form-control" name="quantidade" value="{{ old('quantidade', $compraProduto->quantidade ?? 1) }}" required></div>
  <div class="mb-3"><label>Valor total</label><input type="number" step="0.01" class="form-control" name="valor_total" value="{{ old('valor_total', $compraProduto->valor_total ?? 0) }}" required></div>
  <div class="mb-3"><label>Data da compra</label><input type="date" class="form-control" name="data_compra" value="{{ old('data_compra', $compraProduto->data_compra ?? date('Y-m-d')) }}" required></div>
  <div class="mb-3"><label>Observação</label><textarea class="form-control" name="observacao">{{ old('observacao', $compraProduto->observacao ?? '') }}</textarea></div>
  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('compras-produtos.index') }}">Voltar</a>
</form>
@endsection

            
            