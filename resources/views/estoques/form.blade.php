@extends('main')
@section('titulo', 'Estoque')
@section('conteudo')
<h3>{{ isset($estoque) ? 'Editar estoque' : 'Novo estoque' }}</h3>
<form method="POST" action="{{ isset($estoque) ? route('estoques.update', $estoque) : route('estoques.store') }}" enctype="multipart/form-data">
  @csrf
  @if(isset($estoque)) @method('PUT') @endif
  <div class="mb-3"><label>ID do produto</label><input type="number" class="form-control" name="produto_id" value="{{ old('produto_id', $estoque->produto_id ?? '') }}" required></div>
  <div class="mb-3"><label>Quantidade</label><input type="number" class="form-control" name="quantidade" value="{{ old('quantidade', $estoque->quantidade ?? 0) }}" required></div>
  <div class="mb-3"><label>Foto do produto</label><input type="file" class="form-control" name="foto"></div>
  <div class="mb-3"><label>Lote</label><input class="form-control" name="lote" value="{{ old('lote', $estoque->lote ?? '') }}"></div>
  <div class="mb-3"><label>Localização</label><input class="form-control" name="localizacao" value="{{ old('localizacao', $estoque->localizacao ?? '') }}"></div>
  <div class="mb-3"><label>Status</label><input class="form-control" name="status" value="{{ old('status', $estoque->status ?? 'disponivel') }}"></div>
  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('estoques.index') }}">Voltar</a>
</form>
@endsection