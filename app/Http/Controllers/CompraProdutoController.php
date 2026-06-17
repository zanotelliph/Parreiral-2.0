<?php

namespace App\Http\Controllers;

use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class CompraProdutoController extends Controller
{
    function index(Request $request, LarapexChart $chart)
    {
        $q = trim($request->input('q', ''));

        $compras = CompraProduto::query()
            ->with(['produto'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('item_compra', 'like', "%{$q}%")
                    ->orWhere('observacao', 'like', "%{$q}%");
            })
            ->latest()
            ->get();

        return view('compras-produtos.index', [
            'compras' => $compras,
            'q' => $q,
            'chart' => $this->produtoMaisCompradoChart($chart),
        ]);
    }

    function create()
    {
        $produtos = Produto::orderBy('nome')->get();
        return view('compras-produtos.form', compact('produtos'));
    }

    function store(Request $request)
    {
        $data = $request->validate([
            'produto_id'      => 'required',
            'item_compra'     => 'nullable|string',
            'quantidade'      => 'required|integer|min:1',
            'custo_compra'    => 'nullable|numeric',
            'valor_total'     => 'required|numeric',
            'forma_pagamento' => 'nullable|string',
            'data_compra'     => 'required|date',
            'observacao'      => 'nullable',
        ]);

        CompraProduto::create($data);

        return redirect('compras-produtos')->with('success', 'Compra registrada com sucesso!');
    }

    function edit($id)
    {
        $compraProduto = CompraProduto::findOrFail($id);
        $produtos = Produto::orderBy('nome')->get();

        return view('compras-produtos.form', compact('compraProduto', 'produtos'));
    }

    function update(Request $request, $id)
    {
        $data = $request->validate([
            'produto_id'      => 'required',
            'item_compra'     => 'nullable|string',
            'quantidade'      => 'required|integer|min:1',
            'custo_compra'    => 'nullable|numeric',
            'valor_total'     => 'required|numeric',
            'forma_pagamento' => 'nullable|string',
            'data_compra'     => 'required|date',
            'observacao'      => 'nullable',
        ]);

        CompraProduto::findOrFail($id)->update($data);

        return redirect()->route('compras-produtos.index')->with('success', 'Compra atualizada com sucesso.');
    }

    function destroy($id)
    {
        CompraProduto::findOrFail($id)->delete();
        return redirect()->route('compras-produtos.index')->with('success', 'Compra removida com sucesso.');
    }

    function show($id)
    {
        return redirect()->route('compras-produtos.index');
    }

    function chart(LarapexChart $chart)
    {
        return view('compras-produtos.chart', [
            'chart' => $this->produtoMaisCompradoChart($chart)
        ]);
    }

    private function produtoMaisCompradoChart(LarapexChart $chart): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $produtoPorCompra = DB::table('compras_produtos')
            ->leftJoin('produtos', 'produtos.id', '=', 'compras_produtos.produto_id')
            ->select(
                DB::raw('COALESCE(produtos.nome, CONCAT("Produto #", compras_produtos.produto_id)) as produto_nome'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('produto_nome')
            ->orderByDesc('total')
            ->get();

        return $chart->pieChart()
            ->setTitle('Produto Mais Comprado')
            ->setSubtitle('Compras registradas')
            ->addData($produtoPorCompra->pluck('total')->map(fn ($total) => (int) $total)->all())
            ->setLabels($produtoPorCompra->pluck('produto_nome')->all());
    }
}