@extends('main')
@section('titulo', 'Listagem de clientes')
@section('conteudo')

    <h4>Listagem de clientes</h4>

    <div class="row">
        <div class="col">
            <form action="{{ route('cliente.search') }}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="nome">Nome</option>
                            <option value="cpf">CPF</option>
                            <option value="telefone">Telefone</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Valor</label>
                        <input type="text" class="form-control" name="valor" placeholder="Pesquisar...">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary"> Buscar</button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('cliente/create') }}" class="btn btn-success"> Novo</a>
                    </div>
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
                        <th scope="col">CEP</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Preferências de Compra</th>
                        <th scope="col">Imagem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        @php
                            $nome_imagem = !empty($item->imagem) ? $item->imagem : 'sem_imagem.png';
                        @endphp

                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td> <img src="/storage/{{ $nome_imagem }}" class="rounded-circle" width="150px"
                                    height="150px" alt="imagem">
                            </td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->cep }}</td>
                            <td>{{ $item->cpf }}</td>
                            <td>{{ $item->telefone }}</td>
                            <td>{{ $item->categoria->nome ?? '' }}</td>
                            <td><a href="{{ route('cliente.edit', $item->id) }}" class="btn btn-warning">Editar</a></td>
                            <td>
                                <form action="{{ route('cliente.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Deseja remover o registro?')">
                                        Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
