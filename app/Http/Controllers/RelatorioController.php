<?php

namespace App\Http\Controllers;

use App\Charts\MaiorCliente; 
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

    public function clientes(Request $request, MaiorCliente $chart)
    {
        $dados = $this->dadosClientes($request);

        // Mescla os dados mapeados com o gráfico atualizado
        $dados['chart'] = $chart->build();

        return view('relatorios.clientes', $dados);
    }

    private function dadosCompras(Request $request): array
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $compras = CompraProduto::query()
            ->with(['produto'])
            ->when($dataInicio, fn ($q) => $q->whereDate('data_compra', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('data_compra', '<=', $dataFim))
            ->orderByDesc('data_compra')
            ->get();

        return [
            'compras' => $compras,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'totalGeral' => $compras->sum('valor_total'),
            'totalQuantidade' => $compras->sum('quantidade'),
        ];
    }

    private function dadosClientes(Request $request): array
    {
        $status = $request->input('status_financeiro');

        // Busca todos os dados da tabela cliente
        $clientes = Cliente::query()
            ->orderBy('nome')
            ->get();

        // 1. Contagens de Status Financeiro
        $totalClientes = $clientes->count();
        $clientesEmDia = $clientes->where('status_financeiro', 'em dia')->count();
        $clientesPendentes = $clientes->where('status_financeiro', 'pendente')->count();

        // 2. Contagens de Nível de Fidelidade (Mapeado conforme o seu validador: 0 a 2)
        // Se no seu sistema 0=Bronze, 1=Prata, 2=Ouro:
        $clientesBronze = $clientes->where('nivel_fidelidade', 0)->count();
        $clientesOuro = $clientes->where('nivel_fidelidade', 2)->count();

        // 3. Clientes que já visitaram (número_visitas maior que 0)
        $clientesJaVisitaram = $clientes->where('numero_visitas', '>', 0)->count();

        // Filtro de listagem para a tabela caso o usuário clique nos filtros da tela
        if ($status) {
            $clientes = $clientes->where('status_financeiro', $status);
        }

        return [
            'clientes' => $clientes,
            'status' => $status,
            'totalClientes' => $totalClientes,
            'clientesEmDia' => $clientesEmDia,
            'clientesPendentes' => $clientesPendentes,
            'clientesBronze' => $clientesBronze,
            'clientesOuro' => $clientesOuro,
            'clientesJaVisitaram' => $clientesJaVisitaram,
        ];
    }

    public function chart(MaiorCliente $chart)
    {
        return view('compradores_produtos.chart', [
            'chart' => $chart->build()
        ]);
    }
}