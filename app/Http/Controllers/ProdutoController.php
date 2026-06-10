<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $produtos = Produto::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nome', 'like', "%{$q}%")
                        ->orWhere('categoria_produto', 'like', "%{$q}%")
                        ->orWhere('lote_produto', 'like', "%{$q}%")
                        ->orWhere('tipo_uva', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('produto.index', compact('produtos', 'q'));
    }

    public function create()
    {
        return view('produto.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'categoria_produto' => 'nullable|string|max:100',
            'quantidade_disponivel' => 'nullable|integer|min:0',
            'tipo_uva' => 'nullable|string|max:100',
            'valor_unitario' => 'nullable|numeric',
            'descricao' => 'nullable|string',
            
        ]);

        Produto::create($data);

        return redirect()->route('produto.index')->with('success', 'Produto cadastrado com sucesso.');
    }

    public function edit(Produto $produto)
    {
        return view('produto.form', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'categoria_produto' => 'nullable|string|max:100',
            'quantidade_disponivel' => 'nullable|integer|min:0',
            'tipo_uva' => 'nullable|string|max:100',
            'valor_unitario' => 'nullable|numeric',
            'descricao' => 'nullable|string',
        ]);

        $produto->update($data);

        return redirect()->route('produto.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produto.index')->with('success', 'Produto removido com sucesso.');
    }
}
