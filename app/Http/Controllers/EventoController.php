<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $eventos = Evento::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nome_evento', 'like', "%{$q}%")
                        ->orWhere('descricao', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('eventos.index', compact('eventos', 'q'));
    }

    public function create()
    {
        return view('eventos.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_evento' => 'required|string|max:150',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'hora_inicio' => 'required',
            'data_fim' => 'required|date',
            'hora_fim' => 'required',
            'limite_pessoas' => 'nullable|integer|min:1',
            'valor_ingresso_1' => 'nullable|numeric',
            'valor_ingresso_2' => 'nullable|numeric',
            'valor_ingresso_3' => 'nullable|numeric',
        ]);

        Evento::create($data);

        return redirect()->route('eventos.index')->with('success', 'Evento cadastrado com sucesso.');
    }

    public function edit(Evento $evento)
    {
        return view('eventos.form', compact('evento'));
    }

    public function show(Evento $evento)
    {
        return redirect()->route('eventos.index');
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'nome_evento' => 'required|string|max:150',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'hora_inicio' => 'required',
            'data_fim' => 'required|date',
            'hora_fim' => 'required',
            'limite_pessoas' => 'nullable|integer|min:1',
            'valor_ingresso_1' => 'nullable|numeric',
            'valor_ingresso_2' => 'nullable|numeric',
            'valor_ingresso_3' => 'nullable|numeric',
        ]);

        $evento->update($data);

        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento removido com sucesso.');
    }

    public function pdf()
    {
        $eventos = Evento::all();

        $pdf = Pdf::loadView('eventos.pdf', compact('eventos'));
        $content = $pdf->output();

        return response($content, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="eventos.pdf"');
    }
}

