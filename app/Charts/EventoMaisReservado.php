<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class EventoMaisReservado
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $dados = DB::table('reservas_eventos')
            ->select(
                'evento',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('evento')
            ->orderByDesc('total')
            ->get();

        $eventos = [];
        $quantidades = [];

        foreach ($dados as $item) {
            $eventos[] = $item->evento;
            $quantidades[] = $item->total;
        }

        return $this->chart->pieChart()
            ->setTitle('Eventos Mais Reservados')
            ->addData($quantidades)
            ->setLabels($eventos);
    }
}