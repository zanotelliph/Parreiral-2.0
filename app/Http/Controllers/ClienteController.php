<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cliente;


class clienteController extends Controller
{

    function index()
    {
        $dados = cliente::all(); //select * from cliente

        // dd($dados);
        //var_dump($dados);
        //  exit;

        return view('cliente.list', ['dados' => $dados]);
    }

    function create()
    {
        $categorias = cliente::orderBy('nome')->get();

        return view('cliente.form', ['categorias' => $categorias]);
    }
    function validateRequest(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'email'=> 'required',
            'endereco'=> 'required',
            'cpf' => 'required',
            'preferenciadecompra' => 'nullable|string',
            'historicodevisitas' => 'nullable|string',
            'id' => 'nullable|string|unique:clientes,id',

            'imagem' => 'nullable|image|mimes:png,jpg,jpeg'
            ], [
            'nome.required' => "O :attribute é obrigatório",
            'cpf.required' => "O :attribute é obrigatório",
            'email.required' => "O :attribute é obrigatório",
            'telefone.required' => "O :attribute é obrigatório",
            'preferenciadecompra.string' => ' ex.: vinho favorito',
            'historicodevisitas.int' => 'ex.:1',
            'imagem.image' => "O :attribute deve ser enviado",
            'imagem.mimes' => "O :attribute é deve ser das extensões:PNG, JPEG e JPG",
        ]);
    }

    function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/cliente/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem;
        }

        cliente::create($data);

        return redirect('cliente')->with('success', 'Registro cadastrado com sucesso!');
    }

    function edit($id)
    {
        $dado = cliente::find($id);
        $categorias = Categoriacliente::orderBy('nome')->get();


        return view('cliente.form', [
            'dado' => $dado,
            'categorias' => $categorias
        ]);
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/cliente/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem;
        }

        cliente::find($id)->update($data);

        return redirect('cliente')->with('success', 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        cliente::destroy($id);
        return redirect('cliente')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = cliente::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = cliente::all();
        }

        return view('cliente.list', ['dados' => $dados]);
    }
}
