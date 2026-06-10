@extends('main')
@section('titulo', 'Estoque')
@section('conteudo')

@include('partials.page-header', [
    'title' => 'Estoque',
    'subtitle' => 'Controle de garrafas e insumos do parreiral',
])

<div class="content-panel">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <form class="row g-2 flex-grow-1" method="GET" action="{{ route('estoques.index') }}">
            <div class="col-md-10"><input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Pesquisar lote, local, status ou produto"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Buscar</button></div>
        </form>
        <a href="{{ route('estoques.create') }}" class="btn btn-success text-nowrap">Novo estoque</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th><th>Produto</th><th>Quantidade</th><th>Foto</th>
                    <th>Lote</th><th>Localização</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estoques as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->produto_id }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/'.$item->foto) }}" class="img-thumbnail" width="60" height="60" style="object-fit: cover;" alt="foto">
                            @else — @endif
                        </td>
                        <td>{{ $item->lote }}</td>
                        <td>{{ $item->localizacao }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('estoques.edit', $item) }}">Editar</a>
                            <form class="d-inline" method="POST" action="{{ route('estoques.destroy', $item) }}" onsubmit="return confirm('Excluir?')">
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
