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
        /*
            SELECT evento, COUNT(*) AS total FROM reservas_eventos
                GROUP BY evento
                ORDER BY total DESC
                LIMIT 10
        */

        $dados = DB::table('reservas_eventos')
            ->select(
                'evento',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('evento')
            ->orderByDesc('total')
            ->limit(10) // Mantém o gráfico limpo exibindo o Top 10 eventos
            ->get();

        $eventos = [];
        $quantidades = [];

        foreach ($dados as $item) {
            $eventos[] = $item->evento;
            $quantidades[] = (int) $item->total; // Força para inteiro para evitar problemas de tipo
        }

        return $this->chart->pieChart()
            ->setTitle('Eventos Mais Reservados')
            ->setSubtitle('Ranking de reservas registradas')
            ->addData($quantidades) // Passa o array numérico direto
            ->setXAxis($eventos);   // Passa os nomes dos eventos para o eixo
    }
}