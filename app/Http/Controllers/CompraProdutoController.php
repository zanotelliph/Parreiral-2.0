<?php

namespace App\Http\Controllers;

use App\Models\CompraProduto;
use Illuminate\Http\Request;
use App\Charts\ProdutoMaisComprado;

class CompraProdutoController extends Controller
{
    public function index()
    {
        $compras = CompraProduto::all();

        return view('compras-produtos.index', [
        'compras' => $compras,
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
            'descrição' => 'nullable',
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

    public function edit(CompraProduto $compraProduto)
    {
        return view('compras-produtos.form', compact('compraProduto'));
    }

    public function update(Request $request, CompraProduto $compraProduto)
    {
        $data = $request->validate([
            'produto_id' => 'required|integer',
            'item_compra' => 'required',
            'descrição' => 'nullable',
            'custo_compra' => 'required|numeric',
            'desconto' => 'nullable|numeric',
            'parcelas' => 'required|integer|min:1',
            'forma_pagamento' => 'required|string',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
        ]);

        $compraProduto->update($data);

        return redirect()->route('compras-produtos.index')->with('success', 'Compra atualizada com sucesso.');
    }

    public function destroy(CompraProduto $compraProduto)
    {
        $compraProduto->delete();

        return redirect()->route('compras-produtos.index')->with('success', 'Compra removida com sucesso.');
    }
       function chart(ProdutoMaisComprado $chart)
    {
        return view('compras-produtos.chart', ['chart' => $chart->build()]);
    }
}

