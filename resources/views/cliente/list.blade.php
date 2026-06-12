@extends('main')

@section('titulo', 'Listagem de clientes')

@section('conteudo')

<h4>Listagem de clientes</h4>

<div class="row">
    <div class="col">
        <form action="{{ route('cliente.index') }}" method="get" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Buscar</label>
                <input type="search"
                       name="q"
                       class="form-control"
                       value="{{ $q ?? '' }}"
                       placeholder="Nome, email, telefone ou CPF">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Buscar
                </button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('cliente.create') }}" class="btn btn-success">
                    Novo
                </a>
            </div>
        </form>
    </div>
</div>

<br>

<div class="row">
    <div class="col">

        <table class="table table-hover table-bordered">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data Nascimento</th>
                    <th>CEP</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Status</th>
                    <th>Visitas</th>
                    <th>Fidelidade</th>
                    <th width="150">Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($dados as $item)

                    <tr>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->cpf }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telefone }}</td>
                        <td>{{ $item->data_nascimento }}</td>
                        <td>{{ $item->cep }}</td>
                        <td>{{ $item->cidade }}</td>
                        <td>{{ $item->estado }}</td>
                        <td>{{ $item->status_financeiro ?? 'Em dia' }}</td>
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

                            <a href="{{ route('cliente.edit', $item->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('cliente.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Deseja remover o registro?')">
                                    Deletar
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="13" class="text-center">
                            Nenhum cliente encontrado.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@stop

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
            <a href="{{ url('cliente/create') }}" class="btn btn-success w-100">Novo cliente</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">CEP</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}" class="rounded-circle" width="48" height="48" style="object-fit: cover;">
                        </td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->data_nascimento }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telefone }}</td>
                        <td>{{ $item->cep }}</td>
                        <td>{{ $item->status_financeiro ?? 'em dia' }}</td>
                        <td>
                            <a href="{{ route('cliente.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('cliente.destroy', $item->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja remover o registro?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


 
