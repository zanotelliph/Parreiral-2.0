<?php

namespace App\Http\Controllers;

use App\Charts\EventoMaisReservado; // Classe do gráfico customizado importada corretamente
use App\Models\ReservaEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaEventoController extends Controller
{
    // AJUSTE: Alterado de LarapexChart $chart para EventoMaisReservado $chart
    public function index(Request $request, EventoMaisReservado $chart)
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

        return view('reservas-eventos.index', [
            'reservas' => $reservas,
            'q' => $q,
            'chart' => $chart->build(), // AJUSTE: Agora chama o método build() correto da sua classe customizada
        ]);
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

    public function edit(ReservaEvento $reservas_evento)
    {
        $reservaEvento = $reservas_evento;

        return view('reservas-eventos.form', compact('reservaEvento'));
    }

    public function show(ReservaEvento $reservas_evento)
    {
        return redirect()->route('reservas-eventos.index');
    }

    public function update(Request $request, ReservaEvento $reservas_evento)
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

        $reservas_evento->update($data);

        return redirect()->route('reservas-eventos.index')->with('success', 'Reserva atualizada com sucesso.');
    }

    public function destroy(ReservaEvento $reservas_evento)
    {
        $reservas_evento->delete();

        return redirect()->route('reservas-eventos.index')->with('success', 'Reserva removida com sucesso.');
    }

    // Rota exclusiva para exibição isolada do gráfico
    public function chart(EventoMaisReservado $chart)
    {
        // AJUSTE: Ajustado o nome da view para usar hífen 'reservas-eventos' padronizando com o restante do sistema
        return view('reservas-eventos.chart', [
            'chart' => $chart->build()
        ]);
    }
}