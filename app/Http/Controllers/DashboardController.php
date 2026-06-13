<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CompraProduto;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = DB::connection()->getDriverName();
        $mesExpression = $driver === 'sqlite'
            ? "CAST(strftime('%m', data_compra) AS INTEGER)"
            : 'MONTH(data_compra)';

        $comprasPorMes = CompraProduto::query()
            ->selectRaw($mesExpression . ' as mes, SUM(valor_total) as total')
            ->whereYear('data_compra', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $comprasLabels = [];
        $comprasValores = [];

        for ($i = 1; $i <= 12; $i++) {
            $comprasLabels[] = $meses[$i - 1];
            $comprasValores[] = (float) ($comprasPorMes->firstWhere('mes', $i)->total ?? 0);
        }

        $clientesPorStatus = Cliente::query()
            ->select('status_financeiro', DB::raw('COUNT(*) as total'))
            ->groupBy('status_financeiro')
            ->get();

        $estoquePorStatus = Estoque::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('dashboard', [
            'comprasLabels' => $comprasLabels,
            'comprasValores' => $comprasValores,
            'clientesStatusLabels' => $clientesPorStatus->pluck('status_financeiro')->map(fn ($s) => ucfirst($s))->all(),
            'clientesStatusValores' => $clientesPorStatus->pluck('total')->map(fn ($v) => (int) $v)->all(),
            'estoqueLabels' => $estoquePorStatus->pluck('status')->map(fn ($s) => ucfirst($s ?: 'Sem status'))->all(),
            'estoqueValores' => $estoquePorStatus->pluck('total')->map(fn ($v) => (int) $v)->all(),
            'totalClientes' => Cliente::count(),
            'totalCompras' => CompraProduto::count(),
            'valorTotalCompras' => CompraProduto::sum('valor_total'),
        ]);
    }
}
