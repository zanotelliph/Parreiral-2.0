<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class ProdutoMaisComprado
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

   public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
{
    /*
        SELECT produtos.nome, SUM(compras_produtos.quantidade) as total 
            FROM compras_produtos
            INNER JOIN produtos ON produtos.id = compras_produtos.produto_id
            GROUP BY produtos.id, produtos.nome
            ORDER BY total DESC
            LIMIT 10
    */

    // CORRIGIDO: Agora busca o nome real do produto usando relacionamento de IDs
    $produtoPorCompra = DB::table('compras_produtos')
        ->join('produtos', 'produtos.id', '=', 'compras_produtos.produto_id')
        ->select(
            'produtos.nome as produto_nome', 
            DB::raw('SUM(compras_produtos.quantidade) as total')
        )
        ->groupBy('produtos.id', 'produtos.nome')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    $produtos = [];
    $quantidades = [];

    foreach ($produtoPorCompra as $item) {
        $produtos[] = $item->produto_nome; // CORRIGIDO: Lê a propriedade nova
        $quantidades[] = (int) $item->total;
    }

    return $this->chart->horizontalBarChart()
        ->setTitle('Produtos Mais Comprados')
        ->setSubtitle('Ranking por quantidade total de itens vendidos')
        ->addData($quantidades)
        ->setXAxis($produtos);
}
}