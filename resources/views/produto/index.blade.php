@extends('main')
@section('titulo', 'Produtos')
@section('conteudo')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Produtos</h3>
<div class="mb-3">
  <a href="{{ route('produto.pdf') }}"
   class="btn btn-danger">
    PDF
</a>
</div>
  <a href="{{ route('produto.create') }}" class="btn btn-success">Novo produto</a>
</div>
<form class="row g-2 mb-3" method="GET" action="{{ route('produto.index') }}">
  <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar produto, categoria, lote ou tipo"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
</form>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered">
  <thead><tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Tipo</th><th>Quantidade Disponível</th><th>Preço Unitário</th><th>Descrição</th></tr></thead>
  <tbody>
  @foreach($produtos as $produto)
    <tr>
      <td>{{ $produto->id }}</td>
      <td>{{ $produto->nome }}</td>
      <td>{{ $produto->categoria_produto ?? $produto->tipo }}</td>
      <td>{{ $produto->quantidade_disponivel ?? 0 }}</td>
      <td>{{ $produto->descricao ?? '' }}</td>
      <td>R$ {{ number_format($produto->valor_unitario ?? 0, 2, ',', '.') }}</td>
      <td>{{ $produto->tipo_uva ?? '' }}</td>
      <td>
        <a class="btn btn-sm btn-primary" href="{{ route('produto.edit', $produto) }}">Editar</a>
        <form class="d-inline" method="POST" action="{{ route('produto.destroy', $produto) }}" onsubmit="return confirm('Excluir?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Excluir</button>
=======

@include('partials.page-header', [
    'title' => 'Produtos',
    'subtitle' => 'Catálogo de vinhos, sucos e derivados do parreiral',
])

<div class="content-panel">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <form class="row g-2 flex-grow-1" method="GET" action="{{ route('produto.index') }}">
            <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar produto, categoria, lote ou tipo"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
 
        </form>
        <a href="{{ route('produto.create') }}" class="btn btn-success text-nowrap">Novo produto</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead><tr><th>ID</th><th>Foto</th><th>Nome</th><th>Categoria</th><th>Lote</th><th>Preço</th><th>Desconto</th><th>Ações</th></tr></thead>
            <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>
                        <img src="{{ $produto->imagem_url }}" alt="{{ $produto->nome }}" class="img-thumbnail" width="56" height="56" style="object-fit: cover;">
                    </td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->categoria_produto ?? $produto->tipo_uva }}</td>
                    <td>{{ $produto->lote_produto ?? $produto->lote }}</td>
                    <td>R$ {{ number_format($produto->preco_produto ?? $produto->preco, 2, ',', '.') }}</td>
                    <td>{{ number_format($produto->desconto_promocao ?? 0, 2, ',', '.') }}%</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('produto.edit', $produto) }}">Editar</a>
                        <form class="d-inline" method="POST" action="{{ route('produto.destroy', $produto) }}" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


