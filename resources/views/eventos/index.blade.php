@extends('main')
@section('titulo', 'Eventos')
@section('conteudo')

@include('partials.page-header', [
    'title' => 'Eventos',
    'subtitle' => 'Degustações, colheitas e experiências no parreiral',
])

<div class="content-panel">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-stretch align-items-lg-center gap-2 mb-4">
        <form class="row g-2 flex-grow-1" method="GET" action="{{ route('eventos.index') }}">
            <div class="col-12 col-md-9 col-lg-10">
                <input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar nome ou descrição do evento">
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <button class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>

        <div class="d-grid d-sm-flex gap-2">
            <a href="{{ route('eventos.pdf') }}" class="btn btn-danger text-nowrap">PDF</a>
            <a href="{{ route('eventos.create') }}" class="btn btn-success text-nowrap">Novo evento</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th>Limite</th>
                    <th>Valor Lote 1</th>
                    <th>Valor Lote 2</th>
                    <th>Valor Lote 3</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eventos as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nome_evento }}</td>
                        <td class="text-nowrap">{{ $item->data_inicio }} {{ $item->hora_inicio }}</td>
                        <td class="text-nowrap">{{ $item->data_fim }} {{ $item->hora_fim }}</td>
                        <td>{{ $item->limite_pessoas }}</td>
                        <td class="text-nowrap">R$ {{ number_format($item->valor_ingresso_1 ?? 0, 2, ',', '.') }}</td>
                        <td class="text-nowrap">R$ {{ number_format($item->valor_ingresso_2 ?? 0, 2, ',', '.') }}</td>
                        <td class="text-nowrap">R$ {{ number_format($item->valor_ingresso_3 ?? 0, 2, ',', '.') }}</td>
                        <td>{{ $item->descricao }}</td>
                        <td>
                            <div class="d-grid d-sm-flex gap-2">
                                <a class="btn btn-sm btn-primary" href="{{ route('eventos.edit', $item->id) }}">Editar</a>
                                <form method="POST" action="{{ route('eventos.destroy', $item->id) }}" onsubmit="return confirm('Deseja realmente excluir este evento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger w-100">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Nenhum evento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection