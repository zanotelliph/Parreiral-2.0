@extends('main')
@section('titulo', 'Estoque')
@section('conteudo')

@include('partials.page-header', [
    'title' => isset($estoque) ? 'Editar estoque' : 'Novo estoque',
    'subtitle' => 'Controle de garrafas e lotes do parreiral',
])

<div class="content-panel">
<form method="POST" action="{{ isset($estoque) ? route('estoques.update', $estoque) : route('estoques.store') }}" enctype="multipart/form-data">
  @csrf
  @if(isset($estoque)) @method('PUT') @endif
  <div class="mb-3">
    <label class="form-label">Produto</label>
    <select class="form-select" name="produto_id" required>
      <option value="">Selecione o produto</option>
      @foreach($produtos as $produto)
        <option value="{{ $produto->id }}" @selected(old('produto_id', $estoque->produto_id ?? '') == $produto->id)>{{ $produto->nome }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3"><label class="form-label">Quantidade</label><input type="number" class="form-control" name="quantidade" value="{{ old('quantidade', $estoque->quantidade ?? 0) }}" required></div>
  <div class="mb-3"><label class="form-label">Foto do produto</label><input type="file" class="form-control" name="foto" accept="image/png,image/jpeg,image/jpg"></div>
  <div class="mb-3"><label class="form-label">Lote</label><input class="form-control" name="lote" value="{{ old('lote', $estoque->lote ?? '') }}"></div>
  <div class="mb-3"><label class="form-label">Localização</label><input class="form-control" name="localizacao" value="{{ old('localizacao', $estoque->localizacao ?? '') }}"></div>
  <div class="mb-3"><label class="form-label">Status</label><input class="form-control" name="status" value="{{ old('status', $estoque->status ?? 'disponivel') }}"></div>
  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('estoques.index') }}">Voltar</a>
</form>
</div>
@endsection
