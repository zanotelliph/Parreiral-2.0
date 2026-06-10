<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class EventoMaisReservado
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $produtoPorCompra = DB::table('reserva_evento')
             ->join('evento', 'reserva_evento.evento_id', '=', 'evento.id')
             ->select('evento.nome',DB::raw('COUNT(*) as total'))
             ->groupBy('evento.nome')
             ->orderByDesc('total');
        $tipo_reserva = [];
        $quantidade = [];
        foreach ($produtoPorCompra as $item) {
             $tipo_reserva[]=$item->nome;
             $quantidade[]= $item->total;
        }

            
        return $this->chart->pieChart()
            ->setTitle('Evento Mais Reservado')
            ->setSubtitle('Season 2021.')
            ->addData($quantidade)
            ->setLabels($tipo_reserva);
    }
}