<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function index(Request $request)
    {
        $query = Cadastro::query();

        if ($busca = $request->busca) {
            $query->busca($busca);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('ativo', $request->status);
        }

        $cadastros = $query->latest()->paginate(15);

        return view('cadastros.index', compact('cadastros'));
    }

    public function create()
    {
        return view('cadastros.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => 'required|email|unique:cadastros,email|max:255',
            'telefone'        => 'nullable|string|max:20',
            'documento'       => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'cep'             => 'nullable|string|max:10',
            'logradouro'      => 'nullable|string|max:255',
            'numero'          => 'nullable|string|max:10',
            'complemento'     => 'nullable|string|max:100',
            'bairro'          => 'nullable|string|max:100',
            'cidade'          => 'nullable|string|max:100',
            'estado'          => 'nullable|string|max:2',
            'observacoes'     => 'nullable|string',
            'ativo'           => 'required|boolean',
        ], $this->messages());

        Cadastro::create($validated);

        return redirect()
            ->route('cadastros.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Cadastro $cadastro)
    {
        return view('cadastros.show', compact('cadastro'));
    }

    public function edit(Cadastro $cadastro)
    {
        return view('cadastros.edit', compact('cadastro'));
    }

    public function update(Request $request, Cadastro $cadastro)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => "required|email|unique:cadastros,email,{$cadastro->id}|max:255",
            'telefone'        => 'nullable|string|max:20',
            'documento'       => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'cep'             => 'nullable|string|max:10',
            'logradouro'      => 'nullable|string|max:255',
            'numero'          => 'nullable|string|max:10',
            'complemento'     => 'nullable|string|max:100',
            'bairro'          => 'nullable|string|max:100',
            'cidade'          => 'nullable|string|max:100',
            'estado'          => 'nullable|string|max:2',
            'observacoes'     => 'nullable|string',
            'ativo'           => 'required|boolean',
        ], $this->messages());

        $cadastro->update($validated);

        return redirect()
            ->route('cadastros.show', $cadastro)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cadastro $cadastro)
    {
        $cadastro->delete();

        return redirect()
            ->route('cadastros.index')
            ->with('success', 'Cliente removido com sucesso!');
    }

    private function messages(): array
    {
        return [
            'nome.required'  => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email'    => 'Informe um e-mail válido.',
            'email.unique'   => 'Este e-mail já está cadastrado.',
            'ativo.required' => 'O status é obrigatório.',
        ];
    }
}
