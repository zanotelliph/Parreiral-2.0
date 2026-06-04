<?php

namespace App\Http\Controllers;

use App\Models\ReservaEvento;
use Illuminate\Http\Request;

class ReservaEventoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $reservas = ReservaEvento::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nome_cliente', 'like', "%{$q}%")
                        ->orWhere('evento', 'like', "%{$q}%")
                        ->orWhere('tipo_reserva', 'like', "%{$q}%")
                        ->orWhere('status', 'like', "%{$q}%")
                        ->orWhere('local', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('reservas-eventos.index', compact('reservas', 'q'));
    }

    public function create()
    {
        return view('reservas-eventos.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_cliente' => 'required',
            'evento' => 'required',
            'data_evento' => 'required|date',
            'data_reserva' => 'nullable|date',
            'horario' => 'nullable',
            'tipo_reserva' => 'nullable|string|max:100',
            'local' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_ingresso' => 'required|numeric',
            'status' => 'nullable|string|max:50',
        ]);

        ReservaEvento::create($data);

        return redirect()->route('reservas-eventos.index')->with('success', 'Reserva registrada com sucesso.');
    }

    public function edit(ReservaEvento $reservaEvento)
    {
        return view('reservas-eventos.form', compact('reservaEvento'));
    }

    public function update(Request $request, ReservaEvento $reservaEvento)
    {
        $data = $request->validate([
            'nome_cliente' => 'required',
            'evento' => 'required',
            'data_evento' => 'required|date',
            'data_reserva' => 'nullable|date',
            'horario' => 'nullable',
            'tipo_reserva' => 'nullable|string|max:100',
            'local' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_ingresso' => 'required|numeric',
            'status' => 'nullable|string|max:50',
        ]);

        $reservaEvento->update($data);

        return redirect()->route('reservas-eventos.index')->with('success', 'Reserva atualizada com sucesso.');
    }

    public function destroy(ReservaEvento $reservaEvento)
    {
        $reservaEvento->delete();

        return redirect()->route('reservas-eventos.index')->with('success', 'Reserva removida com sucesso.');
    }
}
