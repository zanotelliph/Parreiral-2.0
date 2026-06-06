@extends('relatorios.pdf.layout')

@section('titulo', 'Relatório de Clientes')

@section('conteudo')
<h1>Relatório de Clientes</h1>
<p class="subtitulo">Clientes com identificador único e histórico de compras</p>

<div class="meta">
    @if($status)
        <span><strong>Status:</strong> {{ ucfirst($status) }}</span>
    @else
        <span>Todos os status</span>
    @endif
</div>

<div class="resumo">
    <div class="resumo-box">
        Total de clientes
        <strong>{{ $totalClientes }}</strong>
    </div>
    <div class="resumo-box">
        Em dia
        <strong>{{ $clientesEmDia }}</strong>
    </div>
    <div class="resumo-box">
        Pendentes
        <strong>{{ $clientesPendentes }}</strong>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Identificador</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>Qtd. compras</th>
            <th>Total compras</th>
            <th>Cadastro</th>
        </tr>
    </thead>
    <tbody>
        @forelse($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->identificador?->codigo_externo ?? '—' }}</td>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ ucfirst($cliente->status_financeiro ?? '—') }}</td>
                <td>{{ $cliente->compras_count }}</td>
                <td>R$ {{ number_format($cliente->compras_sum_valor_total ?? 0, 2, ',', '.') }}</td>
                <td>{{ $cliente->data_cadastro ? \Carbon\Carbon::parse($cliente->data_cadastro)->format('d/m/Y') : '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="vazio">Nenhum cliente encontrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
