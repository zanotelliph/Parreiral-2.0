<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CompraProduto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function compras(Request $request)
    {
        $dados = $this->dadosCompras($request);

        return view('relatorios.compras', $dados);
    }

    public function comprasPdf(Request $request)
    {
        $dados = $this->dadosCompras($request);
        $dados['geradoEm'] = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView('relatorios.pdf.compras', $dados)
            ->setPaper('a4', 'landscape');

        return $pdf->download('relatorio-compras-' . now()->format('Y-m-d') . '.pdf');
    }

    public function clientes(Request $request)
    {
        $dados = $this->dadosClientes($request);

        return view('relatorios.clientes', $dados);
    }

    public function clientesPdf(Request $request)
    {
        $dados = $this->dadosClientes($request);
        $dados['geradoEm'] = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView('relatorios.pdf.clientes', $dados)
            ->setPaper('a4', 'landscape');

        return $pdf->download('relatorio-clientes-' . now()->format('Y-m-d') . '.pdf');
    }

    private function dadosCompras(Request $request): array
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $clienteId = $request->input('cliente_id');

        $compras = CompraProduto::query()
            ->with(['cliente', 'produto'])
            ->when($dataInicio, fn ($q) => $q->whereDate('data_compra', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('data_compra', '<=', $dataFim))
            ->when($clienteId, fn ($q) => $q->where('cliente_id', $clienteId))
            ->orderByDesc('data_compra')
            ->get();

        $clienteFiltrado = $clienteId
            ? Cliente::find($clienteId)?->nome
            : null;

        return [
            'compras' => $compras,
            'clientes' => Cliente::orderBy('nome')->get(),
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'clienteId' => $clienteId,
            'clienteFiltrado' => $clienteFiltrado,
            'totalGeral' => $compras->sum('valor_total'),
            'totalQuantidade' => $compras->sum('quantidade'),
        ];
    }

    private function dadosClientes(Request $request): array
    {
        $status = $request->input('status_financeiro');

        $clientes = Cliente::query()
            ->with(['identificador'])
            ->withCount('compras')
            ->withSum('compras', 'valor_total')
            ->when($status, fn ($q) => $q->where('status_financeiro', $status))
            ->orderBy('nome')
            ->get();

        return [
            'clientes' => $clientes,
            'status' => $status,
            'totalClientes' => $clientes->count(),
            'clientesEmDia' => $clientes->where('status_financeiro', 'em dia')->count(),
            'clientesPendentes' => $clientes->where('status_financeiro', 'pendente')->count(),
        ];
    }
}
