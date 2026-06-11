<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $produtos = Produto::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nome', 'like', "%{$q}%")
                    ->orWhere('categoria_produto', 'like', "%{$q}%")
                    ->orWhere('tipo_uva', 'like', "%{$q}%")
                    ->orWhere('lote', 'like', "%{$q}%")
                    ->orWhere('lote_produto', 'like', "%{$q}%");
            })
            ->latest()
            ->get();

        return view('produto.index', compact('produtos', 'q'));
    }

    public function create()
    {
        return view('produto.form', [
            'dado' => new Produto()
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('imagem/produto', 'public');
        }

        Produto::create($data);

        return redirect()->route('produto.index')
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function edit(Produto $produto)
    {
        return view('produto.form', ['dado' => $produto]);
    }

    public function update(Request $request, Produto $produto)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('imagem')) {
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $data['imagem'] = $request->file('imagem')->store('imagem/produto', 'public');
        }

        $produto->update($data);

        return redirect()->route('produto.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->imagem) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect()->route('produto.index')
            ->with('success', 'Produto removido com sucesso.');
    }

    public function show(Produto $produto)
    {
        return redirect()->route('produto.index');
    }

    public function pdf()
    {
        $produtos = Produto::all();

        $pdf = Pdf::loadView('produto.pdf', compact('produtos'));

        return $pdf->download('produtos.pdf');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nome' => 'required|string|max:100',
            'categoria_produto' => 'nullable|string|max:100',
            'tipo_uva' => 'nullable|string|max:100',
            'lote' => 'nullable|string|max:100',
            'lote_produto' => 'nullable|string|max:100',
            'preco' => 'nullable|numeric',
            'preco_produto' => 'nullable|numeric',
            'desconto_promocao' => 'nullable|numeric',
            'quantidade_disponivel' => 'nullable|integer|min:0',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'descricao' => 'nullable|string',
        ]);
    }
}