@extends('main')
@section('titulo', 'Listagem de clientes')
@section('conteudo')

    <h4>Listagem de clientes</h4>

    <div class="row">
        <div class="col">
            <form action="{{ route('cliente.index') }}" method="get" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Buscar</label>
                    <input type="search" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="Nome, email, telefone ou CPF">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url('cliente/create') }}" class="btn btn-success">Novo</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Data Nascimento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">CEP</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        @php
                            $nome_imagem = !empty($item->imagem) ? $item->imagem : 'sem_imagem.png';
                        @endphp

                        <tr>
                            <th scope="row">{{ $item->id }}</th>
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

@stop
