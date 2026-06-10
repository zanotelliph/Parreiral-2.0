@extends('relatorios.pdf.layout')

@section('titulo', 'Relatório de Compras')

@section('conteudo')
<h1>Relatório de Compras</h1>
<p class="subtitulo">Compras vinculadas aos clientes</p>

<div class="meta">
    @if($dataInicio)
        <span><strong>De:</strong> {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}</span>
    @endif
    @if($dataFim)
        <span><strong>Até:</strong> {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}</span>
    @endif
    @if($clienteFiltrado)
        <span><strong>Cliente:</strong> {{ $clienteFiltrado }}</span>
    @endif
    @if(!$dataInicio && !$dataFim && !$clienteFiltrado)
        <span>Todos os registros</span>
    @endif
</div>

<div class="resumo">
    <div class="resumo-box">
        Total de registros
        <strong>{{ $compras->count() }}</strong>
    </div>
    <div class="resumo-box">
        Quantidade total
        <strong>{{ $totalQuantidade }}</strong>
    </div>
    <div class="resumo-box">
        Valor total
        <strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Fornecedor</th>
            <th>Qtd.</th>
            <th>Valor total</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @forelse($compras as $compra)
            <tr>
                <td>{{ $compra->id }}</td>
                <td>{{ $compra->cliente?->nome ?? '—' }}</td>
                <td>{{ $compra->produto?->nome ?? $compra->produto_id }}</td>
                <td>{{ $compra->fornecedor }}</td>
                <td>{{ $compra->quantidade }}</td>
                <td>R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                <td>{{ $compra->data_compra?->format('d/m/Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="vazio">Nenhuma compra encontrada.</td>
            </tr>
        @endforelse
    </tbody>
    @if($compras->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">Totais</td>
                <td>{{ $totalQuantidade }}</td>
                <td>R$ {{ number_format($totalGeral, 2, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    @endif
</table>
@endsection
