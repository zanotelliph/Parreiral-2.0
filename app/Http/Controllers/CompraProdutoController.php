<?php

namespace App\Http\Controllers;

use App\Models\CompraProduto;
use Illuminate\Http\Request;
use App\Charts\ProdutoMaisComprado;


class CompraProdutoController extends Controller
{
    public function index(ProdutoMaisComprado $chart)
{
    $compras = CompraProduto::all();

    return view('compras-produtos.index', [
        'compras' => $compras,
        'chart' => $chart->build(),
    ]);
}
    public function create()
    {
        return view('compras-produtos.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id' => 'required|integer',
            'item_compra' => 'required',
            'descricao' => 'nullable',
            'custo_compra' => 'required|numeric',
            'desconto' => 'nullable|numeric',
            'parcelas' => 'required|integer|min:1',
            'forma_pagamento' => 'required|string',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
            
        ]);

        CompraProduto::create($data);

        return redirect()->route('compras-produtos.index')->with('success', 'Compra registrada com sucesso.');
    }

    public function edit(CompraProduto $compras_produto)
{
    return view('compras-produtos.form', [
        'compraProduto' => $compras_produto
    ]);
}
   public function update(Request $request, CompraProduto $compras_produto)
{
    $data = $request->validate([
        'produto_id' => 'required|integer',
        'item_compra' => 'required',
        'descricao' => 'nullable',
        'custo_compra' => 'required|numeric',
        'desconto' => 'nullable|numeric',
        'parcelas' => 'required|integer|min:1',
        'forma_pagamento' => 'required|string',
        'valor_total' => 'required|numeric',
        'data_compra' => 'required|date',
    ]);

    $compras_produto->update($data);

    return redirect()
        ->route('compras-produtos.index')
        ->with('success', 'Compra atualizada com sucesso.');
}

    public function destroy(CompraProduto $compras_produto)
    {
        $compras_produto->delete();

        return redirect()->route('compras-produtos.index')->with('success', 'Compra removida com sucesso.');
    }
       function chart(ProdutoMaisComprado $chart)
    {
        return view('compras-produtos.chart', ['chart' => $chart->build()]);
    }
}

