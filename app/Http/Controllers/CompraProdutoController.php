<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Charts\ProdutoMaisComprado;


class CompraProdutoController extends Controller
{
<<<<<<< HEAD
    public function index(ProdutoMaisComprado $chart)
{
    $compras = CompraProduto::all();
=======
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $compras = CompraProduto::query()
            ->with(['cliente', 'produto'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('fornecedor', 'like', "%{$q}%")
                        ->orWhere('produto_id', 'like', "%{$q}%")
                        ->orWhere('observacao', 'like', "%{$q}%")
                        ->orWhereHas('cliente', fn ($c) => $c->where('nome', 'like', "%{$q}%"));
                });
            })
            ->latest()
            ->get();

        return view('compras-produtos.index', compact('compras', 'q'));
    }
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2

    return view('compras-produtos.index', [
        'compras' => $compras,
        'chart' => $chart->build(),
    ]);
}
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('compras-produtos.form', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
<<<<<<< HEAD
            'produto_id' => 'required|integer',
            'item_compra' => 'required',
            'descricao' => 'nullable',
            'custo_compra' => 'required|numeric',
            'desconto' => 'nullable|numeric',
            'parcelas' => 'required|integer|min:1',
            'forma_pagamento' => 'required|string',
=======
            'cliente_id' => 'required|exists:cliente,id',
            'produto_id' => 'required|exists:produtos,id',
            'fornecedor' => 'required',
            'quantidade' => 'required|integer|min:1',
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2
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
<<<<<<< HEAD
        $compras_produto->delete();
=======
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('compras-produtos.form', compact('compraProduto', 'clientes', 'produtos'));
    }

    public function update(Request $request, CompraProduto $compraProduto)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:cliente,id',
            'produto_id' => 'required|exists:produtos,id',
            'fornecedor' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
            'observacao' => 'nullable',
        ]);

        $compraProduto->update($data);

        return redirect()->route('compras-produtos.index')->with('success', 'Compra atualizada com sucesso.');
    }

    public function destroy(CompraProduto $compraProduto)
    {
        $compraProduto->delete();
>>>>>>> 19262168641d0837dcd9295cfe234fbe446609f2

        return redirect()->route('compras-produtos.index')->with('success', 'Compra removida com sucesso.');
    }
       function chart(ProdutoMaisComprado $chart)
    {
        return view('compras-produtos.chart', ['chart' => $chart->build()]);
    }
}

