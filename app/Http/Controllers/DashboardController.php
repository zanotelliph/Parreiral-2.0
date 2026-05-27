<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Controle;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes      = Cadastro::count();
        $totalProdutos      = 0; // ajuste conforme seu modelo de Produto
        $totalMovimentacoes = Controle::count();
        $totalPendentes     = Controle::where('status', 'pendente')->count();

        $ultimosClientes     = Cadastro::latest()->limit(5)->get();
        $ultimasMovimentacoes = Controle::with('cadastro')->latest()->limit(5)->get();

        // Dados mensais para o gráfico de linha
        $dadosMensaisEntrada = $this->dadosMensais('entrada');
        $dadosMensaisSaida   = $this->dadosMensais('saida');

        return view('dashboard', compact(
            'totalClientes',
            'totalProdutos',
            'totalMovimentacoes',
            'totalPendentes',
            'ultimosClientes',
            'ultimasMovimentacoes',
            'dadosMensaisEntrada',
            'dadosMensaisSaida',
        ));
    }

    private function dadosMensais(string $tipo): array
    {
        $dados = Controle::selectRaw('MONTH(created_at) as mes, SUM(valor) as total')
            ->where('tipo', $tipo)
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        return array_map(fn($m) => round($dados[$m] ?? 0, 2), range(1, 12));
    }
}
