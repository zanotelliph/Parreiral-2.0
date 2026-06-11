<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Charts\ProdutoMaisComprado;

class CompraProdutoController extends Controller
{
    public function index(Request $request, ProdutoMaisComprado $chart)
    {
        $q = trim($request->input('q', ''));

        $compras = CompraProduto::query()
            ->with(['cliente', 'produto'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('fornecedor', 'like', "%{$q}%")
                    ->orWhere('produto_id', 'like', "%{$q}%")
                    ->orWhere('observacao', 'like', "%{$q}%")
                    ->orWhereHas('cliente', fn ($c) =>
                        $c->where('nome', 'like', "%{$q}%")
                    );
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
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('compras-produtos.form', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:cliente,id',
            'produto_id' => 'required|exists:produtos,id',
            'fornecedor' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
        ]);

        CompraProduto::create($data);

        return redirect()->route('compras-produtos.index')
            ->with('success', 'Compra registrada com sucesso.');
    }

    public function edit(CompraProduto $compraProduto)
    {
        return view('compras-produtos.form', compact('compraProduto'));
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

        return redirect()->route('compras-produtos.index')
            ->with('success', 'Compra atualizada com sucesso.');
    }

    public function destroy(CompraProduto $compraProduto)
    {
        $compraProduto->delete();

        return redirect()->route('compras-produtos.index')
            ->with('success', 'Compra removida com sucesso.');
    }

    public function chart(ProdutoMaisComprado $chart)
    {
        return view('compras-produtos.chart', [
            'chart' => $chart->build()
        ]);
    }
}