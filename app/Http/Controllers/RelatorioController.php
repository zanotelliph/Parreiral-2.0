<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CompraProduto;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    
    public function compras(Request $request)
    {
        $dados = $this->dadosCompras($request);

        return view('relatorios.compras', $dados);
    }

   
    public function clientes(Request $request)
    {
        $dados = $this->dadosClientes($request);

        return view('relatorios.clientes', $dados);
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