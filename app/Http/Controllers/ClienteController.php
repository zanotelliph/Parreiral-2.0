<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteIdentificador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {

        $dados = Cliente::all();
            

        return view('cliente.list', ['dados' => $dados]);
    }

    public function create()
    {
        return view('cliente.form');
    }
    protected function validateRequest(Request $request, ?int $clienteId = null)
    {
        return $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'nullable|date',
            'email' => 'required|email',
            'telefone' => 'required|string|max:20',

            'cpf' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',

            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',

            'codigo_externo' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('cliente_identificadores', 'codigo_externo')
                    ->ignore($clienteId, 'cliente_id'),
            ],

            'tipo_documento' => 'nullable|string|max:30',
            'documento' => 'nullable|string|max:30',
        ], [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'telefone.required' => 'O telefone é obrigatório',
            'imagem.image' => 'Arquivo inválido de imagem',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $data = $request->only([
            'nome', 'data_nascimento', 'email', 'telefone', 'cep',
            'data_cadastro', 'status_financeiro', 'cpf', 'endereco',
            'preferenciadecompra', 'historicodevisitas',
        ]);

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('imagem/cliente', 'public');
        }

        $cliente = Cliente::create($data);

        return redirect('cliente')->with('success', 'Registro cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Cliente::with('identificador')->findOrFail($id);

        return view('cliente.form', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, (int) $id);

        $cliente = Cliente::findOrFail($id);

        $data = $request->only([
            'nome', 'data_nascimento', 'email', 'telefone', 'cep',
            'data_cadastro', 'status_financeiro', 'cpf', 'endereco',
            'preferenciadecompra', 'historicodevisitas',
        ]);

        if ($request->hasFile('imagem')) {
            if ($cliente->imagem) {
                Storage::disk('public')->delete($cliente->imagem);
            }

            $data['imagem'] = $request->file('imagem')->store('imagem/cliente', 'public');
        }

        $cliente->update($data);

        return redirect('cliente')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Cliente::destroy($id);

        return redirect('cliente')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Cliente::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Cliente::all();
        }

        return view('cliente.list', ['dados' => $dados]);
    }


}