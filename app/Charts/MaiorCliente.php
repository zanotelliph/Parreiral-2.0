<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class MaiorCliente
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        
        $totalClientesCadastrados = DB::table('cliente')->count();

        
        $linhasfinais = ['Clientes Cadastrados'];
        $dadosContagem = [(int) $totalClientesCadastrados];

        return $this->chart->DonutChart()
            ->setTitle('Total de Clientes Cadastrados')
            ->setSubtitle('Quantidade de clientes registrados no sistema')
            ->addData($dadosContagem)
            ->setXAxis($linhasfinais);
    }
}