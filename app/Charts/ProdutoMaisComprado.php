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
    ->select(
        'item_compra',
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('item_compra')
    ->orderByDesc('total')
    ->get();

$produtos = [];
$quantidades = [];

foreach ($produtoPorCompra as $item) {
    $produtos[] = $item->item_compra;
    $quantidades[] = $item->total;
}

        return $this->chart->pieChart()
            ->setTitle('Produto Mais Comprado')
            ->setSubtitle('Compras registradas')
            ->addData($quantidades)
            ->setLabels($produtos);
    }
};