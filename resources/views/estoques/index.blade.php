@extends('main')
@section('titulo', 'Estoque')
@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3"><h3>Estoque</h3><a href="{{ route('estoques.create') }}" class="btn btn-success">Novo estoque</a></div>
<form class="row g-2 mb-3" method="GET" action="{{ route('estoques.index') }}">
  <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar lote, local, status ou produto"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
</form>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered"><thead><tr><th>ID</th><th>Produto</th><th>Quantidade</th><th>Foto</th><th>Lote</th><th>Localização</th><th>Status</th><th>Ações</th></tr></thead><tbody>@foreach($estoques as $item)<tr><td>{{ $item->id }}</td><td>{{ $item->produto_id }}</td><td>{{ $item->quantidade }}</td><td>@if($item->foto)<img src="{{ asset('storage/'.$item->foto) }}" width="60" alt="foto">@else—@endif</td><td>{{ $item->lote }}</td><td>{{ $item->localizacao }}</td><td>{{ $item->status }}</td><td><a class="btn btn-sm btn-primary" href="{{ route('estoques.edit', $item) }}">Editar</a><form class="d-inline" method="POST" action="{{ route('estoques.destroy', $item) }}" onsubmit="return confirm('Excluir?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Excluir</button></form></td></tr>@endforeach</tbody></table>
@endsection