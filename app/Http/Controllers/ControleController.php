<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Controle;
use Illuminate\Http\Request;

class ControleController extends Controller
{
    public function index(Request $request)
    {
        $query = Controle::with('cadastro');

        if ($busca = $request->busca) {
            $query->busca($busca);
        }
        if ($tipo = $request->tipo) {
            $query->tipo($tipo);
        }
        if ($request->data_inicio && $request->data_fim) {
            $query->periodo($request->data_inicio, $request->data_fim . ' 23:59:59');
        }

        $controles = $query->latest()->paginate(15);

        $totalEntradas = Controle::where('tipo', 'entrada')->sum('valor');
        $totalSaidas   = Controle::where('tipo', 'saida')->sum('valor');

        return view('controles.index', compact('controles', 'totalEntradas', 'totalSaidas'));
    }

    public function create()
    {
        $clientes = Cadastro::ativo()->orderBy('nome')->get();
        return view('controles.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao'    => 'required|string|max:255',
            'tipo'         => 'required|in:entrada,saida',
            'valor'        => 'required|numeric|min:0',
            'status'       => 'required|in:pendente,concluido,cancelado',
            'cadastro_id'  => 'nullable|exists:cadastros,id',
            'observacoes'  => 'nullable|string',
        ], $this->messages());

        Controle::create($validated);

        return redirect()
            ->route('controles.index')
            ->with('success', 'Movimentação registrada com sucesso!');
    }

    public function edit(Controle $controle)
    {
        $clientes = Cadastro::ativo()->orderBy('nome')->get();
        return view('controles.edit', compact('controle', 'clientes'));
    }

    public function update(Request $request, Controle $controle)
    {
        $validated = $request->validate([
            'descricao'   => 'required|string|max:255',
            'tipo'        => 'required|in:entrada,saida',
            'valor'       => 'required|numeric|min:0',
            'status'      => 'required|in:pendente,concluido,cancelado',
            'cadastro_id' => 'nullable|exists:cadastros,id',
            'observacoes' => 'nullable|string',
        ], $this->messages());

        $controle->update($validated);

        return redirect()
            ->route('controles.index')
            ->with('success', 'Movimentação atualizada com sucesso!');
    }

    public function destroy(Controle $controle)
    {
        $controle->delete();

        return redirect()
            ->route('controles.index')
            ->with('success', 'Movimentação removida com sucesso!');
    }

    private function messages(): array
    {
        return [
            'descricao.required' => 'A descrição é obrigatória.',
            'tipo.required'      => 'O tipo é obrigatório.',
            'tipo.in'            => 'Tipo deve ser entrada ou saída.',
            'valor.required'     => 'O valor é obrigatório.',
            'valor.numeric'      => 'O valor deve ser numérico.',
            'status.required'    => 'O status é obrigatório.',
        ];
    }
}
