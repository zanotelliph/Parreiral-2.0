<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $estoques = Estoque::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('lote', 'like', "%{$q}%")
                        ->orWhere('localizacao', 'like', "%{$q}%")
                        ->orWhere('status', 'like', "%{$q}%")
                        ->orWhere('produto_id', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('estoques.index', compact('estoques', 'q'));
    }

    public function create()
    {
        return view('estoques.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png',
            'lote' => 'nullable',
            'localizacao' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('estoque', 'public');
        }

        Estoque::create($data);

        return redirect()->route('estoques.index')->with('success', 'Estoque registrado com sucesso.');
    }

    public function edit(Estoque $estoque)
    {
        return view('estoques.form', compact('estoque'));
    }

    public function update(Request $request, Estoque $estoque)
    {
        $data = $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png',
            'lote' => 'nullable',
            'localizacao' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('estoque', 'public');
        }

        $estoque->update($data);

        return redirect()->route('estoques.index')->with('success', 'Estoque atualizado com sucesso.');
    }

    public function destroy(Estoque $estoque)
    {
        $estoque->delete();

        return redirect()->route('estoques.index')->with('success', 'Estoque removido com sucesso.');
    }
}
