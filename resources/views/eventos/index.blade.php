@extends('main')
@section('titulo', 'Eventos')
@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Eventos</h3>
<div class="mb-3">
  <a href="{{ route('eventos.pdf') }}"
   class="btn btn-danger">
    PDF
</a>
</div>
  <a href="{{ route('eventos.create') }}" class="btn btn-success">Novo evento</a>
</div>
<form class="row g-2 mb-3" method="GET" action="{{ route('eventos.index') }}">
  <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar nome ou descrição do evento"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
</form>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Início</th>
      <th>Término</th>
      <th>Limite</th>
      <th>Valor 1</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach($eventos as $item)
      <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->nome_evento }}</td>
        <td>{{ $item->data_inicio }} {{ $item->hora_inicio }}</td>
        <td>{{ $item->data_fim }} {{ $item->hora_fim }}</td>
        <td>{{ $item->limite_pessoas }}</td>
        <td>R$ {{ number_format($item->valor_ingresso_1 ?? 0, 2, ',', '.') }}</td>
        <td>
          <a class="btn btn-sm btn-primary" href="{{ route('eventos.edit', $item) }}">Editar</a>
          <form class="d-inline" method="POST" action="{{ route('eventos.destroy', $item) }}" onsubmit="return confirm('Excluir?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
