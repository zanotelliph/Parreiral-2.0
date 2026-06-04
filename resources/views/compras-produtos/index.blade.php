@extends('main')
@section('titulo', 'Compras de Produtos')
@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3"><h3>Compras de Produtos</h3><a href="{{ route('compras-produtos.create') }}" class="btn btn-success">Nova compra</a></div>
<form class="row g-2 mb-3" method="GET" action="{{ route('compras-produtos.index') }}">
  <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar fornecedor, produto ou observação"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
</form>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered"><thead><tr><th>ID</th><th>Produto</th><th>Fornecedor</th><th>Quantidade</th><th>Valor total</th><th>Data</th><th>Ações</th></tr></thead><tbody>@foreach($compras as $item)<tr><td>{{ $item->id }}</td><td>{{ $item->produto_id }}</td><td>{{ $item->fornecedor }}</td><td>{{ $item->quantidade }}</td><td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td><td>{{ $item->data_compra }}</td><td><a class="btn btn-sm btn-primary" href="{{ route('compras-produtos.edit', $item) }}">Editar</a><form class="d-inline" method="POST" action="{{ route('compras-produtos.destroy', $item) }}" onsubmit="return confirm('Excluir?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Excluir</button></form></td></tr>@endforeach</tbody></table>
@endsection