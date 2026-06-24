@extends('main')
@section('titulo', 'Compra de Produto')
@section('conteudo')

@include('partials.page-header', [
    'title' => isset($compraProduto) ? 'Editar compra' : 'Nova compra',
    'subtitle' => 'Registre movimentações de produtos da vinícola',
])

<div class="content-panel">
    <form method="POST" action="{{ isset($compraProduto) ? route('compras-produtos.update', ['compras_produto' => $compraProduto->id]) : route('compras-produtos.store') }}">
        @csrf
        @if(isset($compraProduto)) 
            @method('PUT') 
        @endif

        <div class="row g-3">
            
            <div class="col-12">
                <label class="form-label">Produto</label>
                <select name="produto_id" class="form-select" required>
                    <option value="">Selecione o produto</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}" @selected(old('produto_id', $compraProduto->produto_id ?? '') == $produto->id)>
                            {{ $produto->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Forma de Pagamento</label>
                <input type="text" class="form-control" name="forma_pagamento" value="{{ old('forma_pagamento', $compraProduto->forma_pagamento ?? '') }}" placeholder="Ex: Pix, Cartão, Dinheiro">
            </div>

            <div class="col-md-6">
                <label class="form-label">Quantidade</label>
                <input type="number" class="form-control" name="quantidade" value="{{ old('quantidade', $compraProduto->quantidade ?? 1) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Valor total</label>
                <input type="number" step="0.01" class="form-control" name="valor_total" value="{{ old('valor_total', $compraProduto->valor_total ?? 0) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Data da compra</label>
                <input type="date" class="form-control" name="data_compra" value="{{ old('data_compra', isset($compraProduto) && $compraProduto->data_compra ? $compraProduto->data_compra->format('Y-m-d') : date('Y-m-d')) }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Observação</label>
                <textarea class="form-control" name="observacao" rows="3">{{ old('observacao', $compraProduto->observacao ?? '') }}</textarea>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-secondary" href="{{ route('compras-produtos.index') }}">Voltar</a>
        </div>
    </form>
</div>
@endsection