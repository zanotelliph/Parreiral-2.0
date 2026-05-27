<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Controle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $inicio = $request->get('inicio', now()->startOfMonth()->format('Y-m-d'));
        $fim    = $request->get('fim',    now()->format('Y-m-d'));

        $query = Controle::with('cadastro')->periodo($inicio, $fim . ' 23:59:59');

        $movimentacoes = $query->latest()->get();
        $entradas      = $movimentacoes->where('tipo', 'entrada')->sum('valor');
        $saidas        = $movimentacoes->where('tipo', 'saida')->sum('valor');
        $novosClientes = Cadastro::whereBetween('created_at', [$inicio, $fim . ' 23:59:59'])->count();

        // Dados para gráficos
        [$labels, $dadosEntrada, $dadosSaida] = $this->dadosSemanas($inicio, $fim);

        $estadosLabels = Cadastro::selectRaw('estado, count(*) as total')
            ->whereNotNull('estado')
            ->groupBy('estado')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'estado');

        return view('relatorios.index', compact(
            'movimentacoes', 'entradas', 'saidas', 'novosClientes',
            'labels', 'dadosEntrada', 'dadosSaida',
            'estadosLabels',
        ) + ['estadosData' => $estadosLabels->values(), 'estadosLabels' => $estadosLabels->keys()]);
    }

    public function exportar(Request $request): Response
    {
        $inicio = $request->get('inicio', now()->startOfMonth()->format('Y-m-d'));
        $fim    = $request->get('fim',    now()->format('Y-m-d'));

        $movimentacoes = Controle::with('cadastro')
            ->periodo($inicio, $fim . ' 23:59:59')
            ->latest()
            ->get();

        $csv  = "ID,Data,Descrição,Cliente,Tipo,Valor,Status\n";
        foreach ($movimentacoes as $m) {
            $csv .= implode(',', [
                $m->id,
                $m->created_at->format('d/m/Y'),
                "\"{$m->descricao}\"",
                "\"{$m->cadastro?->nome}\"",
                $m->tipo,
                number_format($m->valor, 2, ',', '.'),
                $m->status,
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="relatorio_' . now()->format('Ymd') . '.csv"',
        ]);
    }

    private function dadosSemanas(string $inicio, string $fim): array
    {
        // Divide o período em 4 semanas para o gráfico
        $start  = \Carbon\Carbon::parse($inicio);
        $end    = \Carbon\Carbon::parse($fim);
        $diff   = $start->diffInDays($end);
        $chunk  = max(1, (int) ceil($diff / 4));

        $labels      = [];
        $dadosEntrada = [];
        $dadosSaida   = [];

        for ($i = 0; $i < 4; $i++) {
            $s = $start->copy()->addDays($i * $chunk);
            $e = $start->copy()->addDays(min(($i + 1) * $chunk - 1, $diff));
            if ($s->gt($end)) break;

            $labels[]       = $s->format('d/m');
            $dadosEntrada[] = round(Controle::where('tipo','entrada')->periodo($s, $e->endOfDay())->sum('valor'), 2);
            $dadosSaida[]   = round(Controle::where('tipo','saida')->periodo($s, $e->endOfDay())->sum('valor'), 2);
        }

        return [$labels, $dadosEntrada, $dadosSaida];
    }
}
