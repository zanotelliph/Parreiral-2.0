@extends('main')
@section('titulo', 'eventoss')
@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>eventoss</h3>
<div class="mb-3">
  <a href="{{ route('eventos.pdf') }}"
   class="btn btn-danger">
    PDF
</a>
</div>
  <a href="{{ route('eventos.create') }}" class="btn btn-success">Novo eventos</a>
</div>
<form class="row g-2 mb-3" method="GET" action="{{ route('eventos.index') }}">
  <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar eventos"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
</form>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered">
  <thead><tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Tipo</th><th>Quantidade Disponível</th><th>Preço Unitário</th><th>Descrição</th></tr></thead>
  <tbody>
  @foreach($eventoss as $eventos)
    <tr>
      <td>{{ $eventos->id }}</td>
      <td>{{ $eventos->nome }}</td>
      <td>{{ $eventos->categoria_eventos ?? $eventos->tipo }}</td>
      <td>{{ $eventos->quantidade_disponivel ?? 0 }}</td>
      <td>{{ $eventos->descricao ?? '' }}</td>
      <td>R$ {{ number_format($eventos->valor_unitario ?? 0, 2, ',', '.') }}</td>
      <td>{{ $eventos->tipo_uva ?? '' }}</td>
      <td>
        <a class="btn btn-sm btn-primary" href="{{ route('eventos.edit', $eventos) }}">Editar</a>
        <form class="d-inline" method="POST" action="{{ route('eventos.destroy', $eventos) }}" onsubmit="return confirm('Excluir?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Excluir</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
