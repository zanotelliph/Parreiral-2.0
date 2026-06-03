<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produto;

class ProdutoController extends Controller
{

    function index()
    {
        $dados = produto::all(); //select * from produto

        return view('produto.list', [
            'produto' => $produto
        ]);
    }

    public function create()
    {
        return view('produto.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'telefone' => 'required|max:20',
            'email' => 'required|email|unique:produto,email',
            'endereco' => 'required|max:200',
            'preferenciasCompra' => 'nullable',
            'historicoVisitas' => 'nullable',
            'identificadorUnico' => 'required|unique:produto,identificadorUnico'
        ]);

        produto::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'endereco' => $request->endereco,
            'preferenciasCompra' => $request->preferenciasCompra,
            'historicoVisitas' => $request->historicoVisitas,
            'identificadorUnico' => $request->identificadorUnico
        ]);

        return redirect('/produto');
    }

    public function show(produto $produto)
    {
        return view('produto.show', [
            'produto' => $produto
        ]);
    }


    public function edit(produto $produto)
    {
        return view('produto.form', [
            'produto' => $produto
        ]);
    }

    public function update(Request $request, produto $produto)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'telefone' => 'required|max:20',
            'email' => 'required|email|unique:produto,email,' . $produto->id,
            'endereco' => 'required|max:200',
            'preferenciasCompra' => 'nullable',
            'historicoVisitas' => 'nullable',
            'identificadorUnico' => 'required|unique:produto,identificadorUnico,' . $produto->id
        ]);

        $produto->update([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'endereco' => $request->endereco,
            'preferenciasCompra' => $request->preferenciasCompra,
            'historicoVisitas' => $request->historicoVisitas,
            'identificadorUnico' => $request->identificadorUnico
        ]);

        return redirect('/produto');
    }

    public function destroy(produto $produto)
    {
        $produto->delete();

        return redirect('/produto');
    }
}
