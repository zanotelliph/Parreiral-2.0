<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cliente;


class clienteController extends Controller
{

    function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $dados = cliente::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nome', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('telefone', 'like', "%{$q}%")
                        ->orWhere('cpf', 'like', "%{$q}%");
                });
            })
            ->get();

        return view('cliente.list', ['dados' => $dados, 'q' => $q]);
    }

   function create()
{
    return view('cliente.form');
}
    function validateRequest(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'nullable|date',
            'email' => 'required|email',
            'telefone' => 'required|string|max:20',
            'cep' => 'nullable|string|max:10',
            'data_cadastro' => 'nullable|date',
            'status_financeiro' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',
            'preferenciadecompra' => 'nullable|string',
            'historicodevisitas' => 'nullable|string',
            'rua' => 'nullable|string|max:300',
            'numero' => 'nullable|string|max:50',
            'complemento' => 'nullable|string|max:300',
            'bairro' => 'nullable|string|max:300',
            'cidade' => 'nullable|string|max:300',
            'estado' => 'nullable|string|max:2',

            'observacoes' => 'nullable|string',

            'numero_visitas' => 'nullable|integer',

            'data_ultima_visita' => 'nullable|date',

            'cliente_fidelizado' => 'nullable|boolean',

            'nivel_fidelidade' => 'nullable|integer',

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
        $categorias = cliente::orderBy('nome')->get();


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
