@extends('main')
@section('titulo', 'Reserva de Evento')
@section('conteudo')
<h3>{{ isset($reservaEvento) ? 'Editar reserva' : 'Nova reserva' }}</h3>
<form method="POST" action="{{ isset($reservaEvento) ? route('reservas-eventos.update', $reservaEvento) : route('reservas-eventos.store') }}">
  @csrf
  @if(isset($reservaEvento)) @method('PUT') @endif
  <div class="mb-3"><label>Nome do cliente</label><input class="form-control" name="nome_cliente" value="{{ old('nome_cliente', $reservaEvento->nome_cliente ?? '') }}" required></div>
  <div class="mb-3"><label>Evento</label><input class="form-control" name="evento" value="{{ old('evento', $reservaEvento->evento ?? '') }}" required></div>
  <div class="mb-3"><label>Data da reserva</label><input type="date" class="form-control" name="data_reserva" value="{{ old('data_reserva', $reservaEvento->data_reserva ?? '') }}"></div>
  <div class="mb-3"><label>Horário</label><input type="time" class="form-control" name="horario" value="{{ old('horario', $reservaEvento->horario ?? '') }}"></div>
  <div class="mb-3"><label>Tipo da reserva</label><input class="form-control" name="tipo_reserva" value="{{ old('tipo_reserva', $reservaEvento->tipo_reserva ?? '') }}"></div>
  <div class="mb-3"><label>Data do evento</label><input type="date" class="form-control" name="data_evento" value="{{ old('data_evento', $reservaEvento->data_evento ?? '') }}" required></div>
  <div class="mb-3"><label>Local</label><input class="form-control" name="local" value="{{ old('local', $reservaEvento->local ?? '') }}" required></div>
  <div class="mb-3"><label>Quantidade</label><input type="number" class="form-control" name="quantidade" value="{{ old('quantidade', $reservaEvento->quantidade ?? 1) }}" required></div>
  <div class="mb-3"><label>Valor do ingresso</label><input type="number" step="0.01" class="form-control" name="valor_ingresso" value="{{ old('valor_ingresso', $reservaEvento->valor_ingresso ?? 0) }}" required></div>
  <div class="mb-3"><label>Status</label><input class="form-control" name="status" value="{{ old('status', $reservaEvento->status ?? 'pendente') }}"></div>
  <button class="btn btn-success">Salvar</button>
  <a class="btn btn-secondary" href="{{ route('reservas-eventos.index') }}">Voltar</a>
</form>
@endsection