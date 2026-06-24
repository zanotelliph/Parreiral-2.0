<?php

namespace App\Http\Controllers;

use App\Charts\ProdutoMaisComprado; 
use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;

class CompraProdutoController extends Controller
{
    public function index(Request $request, ProdutoMaisComprado $chart)
    {
        $q = trim($request->input('q', ''));  

        $compras = CompraProduto::query() 
            ->with(['produto']) 
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    
                    $subQuery->where('produto_id', 'like', "%{$q}%")
                            
                             ->orWhere('observacao', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('compras-produtos.index', [ 
            'compras' => $compras,
            'q' => $q,
            'chart' => $chart->build(), 
        ]);
    }

    public function create()
    {
        $produtos = Produto::orderBy('nome')->get();
        return view('compras-produtos.form', compact('produtos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id'      => 'required|exists:produtos,id', 
            'quantidade'      => 'required|integer|min:1',
            'custo_compra'    => 'nullable|numeric',
            'valor_total'     => 'required|numeric',
            'forma_pagamento' => 'nullable|string',
            'data_compra'     => 'required|date',
            'observacao'      => 'nullable',
            'item_compra'     => 'nullable',
        ]);

        CompraProduto::create($data);

        return redirect()->route('compras-produtos.index')->with('success', 'Compra registrada com sucesso!');
    }

    public function edit($id)
    {
        $compraProduto = CompraProduto::findOrFail($id);
        $produtos = Produto::orderBy('nome')->get();

        return view('compras-produtos.form', compact('compraProduto', 'produtos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'produto_id'      => 'required|exists:produtos,id',
            'quantidade'      => 'required|integer|min:1',
            'custo_compra'    => 'nullable|numeric',
            'valor_total'     => 'required|numeric',
            'forma_pagamento' => 'nullable|string',
            'data_compra'     => 'required|date',
            'observacao'      => 'nullable',
        ]);

        CompraProduto::findOrFail($id)->update($data);

        return redirect()->route('compras-produtos.index')->with('success', 'Compra atualizada com sucesso.');
    }

    public function destroy($id)
    {
        CompraProduto::findOrFail($id)->delete();
        return redirect()->route('compras-produtos.index')->with('success', 'Compra removida com sucesso.');
    }

    public function show($id) 
    {
        return redirect()->route('compras-produtos.index');
    }

    public function chart(ProdutoMaisComprado $chart)
    {
        return view('compras-produtos.chart', [
            'chart' => $chart->build()
        ]);
    }
}