<?php


namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
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
                        ->orWhere('tipo_uva', 'like', "%{$q}%")
                        ->orWhere('lote', 'like', "%{$q}%")
                        ->orWhere('lote_produto', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('produto.index', [
            'produtos' => $produtos,
            'q' => $q
        ]);
    }

    public function create()
    {
        return view('produto.form', [
            'dado' => new Produto()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'categoria_produto' => 'nullable|string|max:100',
            'tipo_uva' => 'nullable|string|max:100',
            'lote' => 'nullable|string|max:100',
            'lote_produto' => 'nullable|string|max:100',
            'preco' => 'nullable|numeric',
            'preco_produto' => 'nullable|numeric',
            'desconto_promocao' => 'nullable|numeric',
            'quantidade_disponivel' => 'nullable|integer|min:0',
            'descricao' => 'nullable|string',
        ]);

        Produto::create($data);

        return redirect()
            ->route('produto.index')
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function edit(Produto $produto)
    {
        return view('produto.form', [
            'dado' => $produto
        ]);
    }

    public function update(Request $request, Produto $produto)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'categoria_produto' => 'nullable|string|max:100',
            'tipo_uva' => 'nullable|string|max:100',
            'lote' => 'nullable|string|max:100',
            'lote_produto' => 'nullable|string|max:100',
            'preco' => 'nullable|numeric',
            'preco_produto' => 'nullable|numeric',
            'desconto_promocao' => 'nullable|numeric',
            'quantidade_disponivel' => 'nullable|integer|min:0',
            'descricao' => 'nullable|string',
        ]);

        $produto->update($data);

        return redirect()
            ->route('produto.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }
    public function show(Produto $produto)
{
    return redirect()->route('produto.index');
}
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()
            ->route('produto.index')
            ->with('success', 'Produto removido com sucesso.');
    }
  public function pdf()
{
    $produtos = Produto::all();

    $pdf = Pdf::loadView('produto.pdf', compact('produtos'));
    $content = $pdf->output();
    
    return response($content, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="produtos.pdf"');
}
}