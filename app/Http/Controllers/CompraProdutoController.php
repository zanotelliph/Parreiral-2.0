<?php

namespace App\Http\Controllers;

use App\Models\CompraProduto;
use Illuminate\Http\Request;

class CompraProdutoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $compras = CompraProduto::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('fornecedor', 'like', "%{$q}%")
                        ->orWhere('produto_id', 'like', "%{$q}%")
                        ->orWhere('observacao', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('compras-produtos.index', compact('compras', 'q'));
    }

    public function create()
    {
        return view('compras-produtos.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id' => 'required|integer',
            'fornecedor' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
            'observacao' => 'nullable',
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

        return redirect()->route('compras-produtos.index')->with('success', 'Compra removida com sucesso.');
    }
}
