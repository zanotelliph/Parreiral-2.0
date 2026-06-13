@extends('main')

@section('titulo', 'Listagem de clientes')

@section('conteudo')
@include('partials.page-header', [
    'title' => 'Clientes',
    'subtitle' => 'Cadastro e gestão dos amantes da vinícola',
])

<div class="content-panel">
    <form action="{{ route('cliente.index') }}" method="get" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label">Buscar</label>
            <input type="search" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="Nome, email, telefone ou CPF">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('cliente.create') }}" class="btn btn-success w-100">Novo cliente</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">CEP</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Status</th>
                    <th scope="col">Visitas</th>
                    <th scope="col">Fidelidade</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}" class="rounded-circle" width="48" height="48" style="object-fit: cover;">
                        </td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->cpf }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telefone }}</td>
                        <td>{{ $item->cep }}</td>
                        <td>{{ $item->cidade }}</td>
                        <td>{{ $item->estado }}</td>
                        <td>{{ $item->status_financeiro ?? 'em dia' }}</td>
                        <td>{{ $item->numero_visitas ?? 0 }}</td>
                        <td>
                            @if (($item->nivel_fidelidade ?? 0) == 0)
                                Bronze
                            @elseif (($item->nivel_fidelidade ?? 0) == 1)
                                Prata
                            @else
                                Ouro
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cliente.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('cliente.destroy', $item->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja remover o registro?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">Nenhum cliente encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
