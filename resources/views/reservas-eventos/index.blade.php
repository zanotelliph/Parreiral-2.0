@extends('main')

@section('titulo', 'Reservas de Eventos')

@section('conteudo')


@if(isset($chart))
<div class="card mb-4">
    <div class="card-body">
        {!! $chart->container() !!}
    </div>
</div>
@endif

@if(isset($chart))
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Reservas de Eventos</h3>
    <a href="{{ route('reservas-eventos.create') }}" class="btn btn-success">
        Nova reserva
    </a>
</div>

<form class="row g-2 mb-3" method="GET" action="{{ route('reservas-eventos.index') }}">
    <div class="col-md-10">
        <input type="search" name="q" value="{{ $q ?? '' }}" class="form-control"
            placeholder="Pesquisar cliente, evento, tipo ou status">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Buscar</button>
    </div>
</form>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Evento</th>
            <th>Data reserva</th>
            <th>Horário</th>
            <th>Tipo</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservas as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->nome_cliente }}</td>
            <td>{{ $item->evento }}</td>
            <td>{{ $item->data_reserva ?? $item->data_evento }}</td>
            <td>{{ $item->horario }}</td>
            <td>{{ $item->tipo_reserva }}</td>
            <td>{{ $item->status }}</td>
            <td>
                <a class="btn btn-sm btn-primary"
                    href="{{ route('reservas-eventos.edit', $item) }}">
                    Editar
                </a>

                <form class="d-inline"
                    method="POST"
                    action="{{ route('reservas-eventos.destroy', $item) }}"
                    onsubmit="return confirm('Excluir?')">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger">
                        Excluir
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@include('partials.page-header', [
    'title' => 'Reservas de Eventos',
    'subtitle' => 'Agendamentos para degustações e visitas à vinícola',
])

<div class="content-panel">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <form class="row g-2 flex-grow-1" method="GET" action="{{ route('reservas-eventos.index') }}">
            <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar cliente, evento, tipo ou status"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
        </form>
        <a href="{{ route('reservas-eventos.create') }}" class="btn btn-success text-nowrap">Nova reserva</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th><th>Cliente</th><th>Evento</th><th>Data reserva</th>
                    <th>Horário</th><th>Tipo</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nome_cliente }}</td>
                        <td>{{ $item->evento }}</td>
                        <td>{{ $item->data_reserva ?? $item->data_evento }}</td>
                        <td>{{ $item->horario }}</td>
                        <td>{{ $item->tipo_reserva }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('reservas-eventos.edit', $item) }}">Editar</a>
                            <form class="d-inline" method="POST" action="{{ route('reservas-eventos.destroy', $item) }}" onsubmit="return confirm('Excluir?')">
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
@endsection
 
