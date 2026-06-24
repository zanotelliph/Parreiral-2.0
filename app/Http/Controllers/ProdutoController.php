<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    function index(Request $request)
    {
        if (!empty($request->q)) {
            $dados = Produto::where('nome', 'like', '%' . $request->q . '%')
                ->orWhere('categoria_produto', 'like', '%' . $request->q . '%')
                ->orWhere('tipo_uva', 'like', '%' . $request->q . '%')
                ->orWhere('lote', 'like', '%' . $request->q . '%')
                ->orWhere('lote_produto', 'like', '%' . $request->q . '%')
                ->latest()
                ->get();
        } else {
            $dados = Produto::latest()->get();
        }

        return view('produto.index', ['produtos' => $dados, 'q' => $request->q]);
    }

    function create()
    {
        return view('produto.form', [
            'dado' => new Produto()
        ]);
    }

    function validateRequest(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'categoria_produto' => 'required|max:100',
            'tipo_uva' => 'required|max:100',
            'lote_produto' => 'nullable|max:100',
            'preco_produto' => 'required|numeric',
            'desconto_promocao' => 'nullable|numeric',
            'quantidade_disp' => 'nullable|integer|min:0',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'descricao' => 'nullable|string',
        ], [
            'nome.required' => "O :attribute é obrigatório",
            'categoria_produto.required' => "O :attribute é obrigatório",
            'tipo_uva.required' => "O :attribute é obrigatório",
            'tipo_uva.max' => "O :attribute deve ter no máximo :max caracteres",
            'preco_produto.required' => "O :attribute é obrigatório",
            'preco_produto.numeric' => "O :attribute deve ser um número válido",
            'desconto_promocao.numeric' => "O :attribute deve ser um número válido",
            'quantidade_disp.integer' => "O :attribute deve ser um número inteiro",
            'quantidade_disp.min' => "O :attribute deve ser no mínimo :min",
            'imagem.image' => "O :attribute deve ser uma imagem válida",
            'imagem.mimes' => "O :attribute deve ser das extensões: PNG, JPEG e JPG",
        ]);
    }

    function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/produto/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public'); 

            $data['imagem'] = $diretorio . $nome_imagem; 
        }

        Produto::create($data);

        return redirect()->route('produto.index')->with('success', 'Registro cadastrado com sucesso!');
    }

    function edit($id)
    {
        $dado = Produto::find($id);

        return view('produto.form', ['dado' => $dado]); 
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $produto = Produto::find($id);
        $imagem = $request->file('imagem');

        if ($imagem) {
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/produto/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem; 
        }

        $produto->update($data);

        return redirect()->route('produto.index')->with('success', 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        $produto = Produto::find($id);

        if ($produto->imagem) {
            Storage::disk('public')->delete($produto->imagem);
        }

        Produto::destroy($id);

        return redirect()->route('produto.index')->with('success', 'Registro removido com sucesso!');
    }

    function show($id)
    {
        return redirect()->route('produto.index');
    }

    function pdf()
    {
        $produtos = Produto::all();

        $pdf = Pdf::loadView('produto.pdf', compact('produtos'));

        return $pdf->download('produtos.pdf');
    }
}