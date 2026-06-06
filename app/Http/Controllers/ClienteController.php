<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteIdentificador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $dados = Cliente::query()
            ->with('identificador')
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

    public function create()
    {
        return view('cliente.form');
    }

    public function validateRequest(Request $request, ?int $clienteId = null)
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
            'codigo_externo' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('cliente_identificadores', 'codigo_externo')->ignore($clienteId, 'cliente_id'),
            ],
            'tipo_documento' => 'nullable|string|max:30',
            'documento' => 'nullable|string|max:30',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ], [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'telefone.required' => 'O telefone é obrigatório',
            'imagem.image' => 'A imagem deve ser um arquivo válido',
            'imagem.mimes' => 'A imagem deve ser PNG, JPEG ou JPG',
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
        $this->syncIdentificador($cliente, $request);

        return redirect('cliente')->with('success', 'Registro cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Cliente::with('identificador')->findOrFail($id);

        return view('cliente.form', ['dado' => $dado]);
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
        $this->syncIdentificador($cliente, $request);

        return redirect('cliente')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Cliente::destroy($id);

        return redirect('cliente')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (! empty($request->valor)) {
            $dados = Cliente::with('identificador')
                ->where($request->tipo, 'like', '%' . $request->valor . '%')
                ->get();
        } else {
            $dados = Cliente::with('identificador')->get();
        }

        return view('cliente.list', ['dados' => $dados]);
    }

    private function syncIdentificador(Cliente $cliente, Request $request): void
    {
        if (! $request->filled('codigo_externo')) {
            return;
        }

        ClienteIdentificador::updateOrCreate(
            ['cliente_id' => $cliente->id],
            [
                'codigo_externo' => $request->input('codigo_externo'),
                'tipo_documento' => $request->input('tipo_documento', 'cpf'),
                'documento' => $request->input('documento', $cliente->cpf),
            ]
        );
    }
}
