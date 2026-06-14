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
        $q = trim(request('q', ''));

        $dados = Cliente::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nome', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('telefone', 'like', "%{$q}%")
                    ->orWhere('cpf', 'like', "%{$q}%");
            })
            ->orderBy('nome')
            ->get();
            

        return view('cliente.list', compact('dados', 'q'));
    }

    public function create()
    {
        return view('cliente.form', ['dado' => new Cliente()]);
    }
    protected function validateRequest(Request $request, ?int $clienteId = null)
    {
        return $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'nullable|date',
            'email' => 'required|email',
            'telefone' => 'required|string|max:20',

            'cpf' => 'required|string|max:16',
            'endereco' => 'required|string|max:300',

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
            'cep' => 'nullable|string|max:10',
            'data_cadastro' => 'nullable|date',
            'status_financeiro' => 'nullable|string|max:50',
            'rua' => 'nullable|string|max:300',
            'numero' => 'nullable|string|max:50',
            'complemento' => 'nullable|string|max:300',
            'bairro' => 'nullable|string|max:300',
            'cidade' => 'nullable|string|max:300',
            'estado' => 'nullable|string|max:2',
            'preferenciadecompra' => 'nullable|string|max:500',
            'observacoes' => 'nullable|string',
            'numero_visitas' => 'nullable|integer|min:0',
            'data_ultima_visita' => 'nullable|date',
            'cliente_fidelizado' => 'nullable|boolean',
            'nivel_fidelidade' => 'nullable|integer|min:0|max:2',
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
            'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado',
            'preferenciadecompra', 'observacoes', 'numero_visitas',
            'data_ultima_visita', 'cliente_fidelizado', 'nivel_fidelidade',
            'historicodevisitas',
        ]);

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('imagem/cliente', 'public');
        }

        $cliente = Cliente::create($data);
        $this->salvarIdentificador($request, $cliente);

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
            'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado',
            'preferenciadecompra', 'observacoes', 'numero_visitas',
            'data_ultima_visita', 'cliente_fidelizado', 'nivel_fidelidade',
            'historicodevisitas',
        ]);

        if ($request->hasFile('imagem')) {
            if ($cliente->imagem) {
                Storage::disk('public')->delete($cliente->imagem);
            }

            $data['imagem'] = $request->file('imagem')->store('imagem/cliente', 'public');
        }

        $cliente->update($data);
        $this->salvarIdentificador($request, $cliente);

        return redirect('cliente')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        if ($cliente->imagem) {
            Storage::disk('public')->delete($cliente->imagem);
        }

        $cliente->delete();

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


    private function salvarIdentificador(Request $request, Cliente $cliente): void
    {
        if (!$request->filled('documento') && !$request->filled('codigo_externo')) {
            return;
        }

        ClienteIdentificador::updateOrCreate(
            ['cliente_id' => $cliente->id],
            [
                'codigo_externo' => $request->input('codigo_externo') ?: 'CLI-' . $cliente->id,
                'tipo_documento' => $request->input('tipo_documento', 'cpf'),
                'documento' => $request->input('documento'),
            ]
        );
    }
}
