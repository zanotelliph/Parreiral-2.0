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

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $produtoPorCompra = DB::table('compras_produtos')
             ->join('produto', 'compras_produtos.produto_id', '=', 'produto.id')
             ->select('produto.nome',DB::raw('COUNT(*) as total'))
             ->groupBy('produto.nome')
             ->orderByDesc('total');
        $produtos = [];
        $quantidades = [];
        foreach ($produtoPorCompra as $item) {
             $produtos=[];
             $quantidades= [];
    }


        return $this->chart->pieChart()
            ->setTitle('Produto Mais Comprado')
            ->setSubtitle('Season 2021.')
            ->addData($quantidades)
            ->setLabels($produtos);
    }
}
