@extends('main')
@section('titulo', 'Evento')
@section('conteudo')

@include('partials.page-header', [
    'title' => isset($evento) ? 'Editar evento' : 'Novo evento',
    'subtitle' => 'Degustações e experiências no parreiral',
])

<div class="content-panel">
    <form method="POST" action="{{ isset($evento) ? route('eventos.update', $evento->id) : route('eventos.store') }}">
        @csrf
        @if(isset($evento)) 
            @method('PUT') 
        @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome do evento</label>
                <input class="form-control" name="nome_evento" value="{{ old('nome_evento', $evento->nome_evento ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Limite de pessoas</label>
                <input type="number" class="form-control" name="limite_pessoas" value="{{ old('limite_pessoas', $evento->limite_pessoas ?? 0) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Data de início</label>
                <input type="date" class="form-control" name="data_inicio" value="{{ old('data_inicio', $evento->data_inicio ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Hora de início</label>
                <input type="time" class="form-control" name="hora_inicio" value="{{ old('hora_inicio', $evento->hora_inicio ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Data de término</label>
                <input type="date" class="form-control" name="data_fim" value="{{ old('data_fim', $evento->data_fim ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Hora de término</label>
                <input type="time" class="form-control" name="hora_fim" value="{{ old('hora_fim', $evento->hora_fim ?? '') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Valor ingresso lote 1</label>
                <input type="number" step="0.01" class="form-control" name="valor_ingresso_1" value="{{ old('valor_ingresso_1', $evento->valor_ingresso_1 ?? 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Valor ingresso lote 2</label>
                <input type="number" step="0.01" class="form-control" name="valor_ingresso_2" value="{{ old('valor_ingresso_2', $evento->valor_ingresso_2 ?? 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Valor ingresso lote 3</label>
                <input type="number" step="0.01" class="form-control" name="valor_ingresso_3" value="{{ old('valor_ingresso_3', $evento->valor_ingresso_3 ?? 0) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao" rows="3">{{ old('descricao', $evento->descricao ?? '') }}</textarea>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-secondary" href="{{ route('eventos.index') }}">Voltar</a>
        </div>
    </form>
</div>
@endsection