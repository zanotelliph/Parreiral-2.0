<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class CompraProdutoController extends Controller
{
    public function index(Request $request, LarapexChart $chart)
    {
        $q = trim($request->input('q', ''));

        $compras = CompraProduto::query()
            ->with(['cliente', 'produto'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('fornecedor', 'like', "%{$q}%")
                    ->orWhere('produto_id', 'like', "%{$q}%")
                    ->orWhere('observacao', 'like', "%{$q}%")
                    ->orWhereHas('cliente', fn ($c) =>
                        $c->where('nome', 'like', "%{$q}%")
                    );
            })
            ->latest()
            ->get();

        return view('compras-produtos.index', [
            'compras' => $compras,
            'q' => $q,
            'chart' => $this->produtoMaisCompradoChart($chart),
        ]);
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('compras-produtos.form', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:cliente,id',
            'produto_id' => 'required|exists:produtos,id',
            'fornecedor' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
            'observacao' => 'nullable',
        ]);

        CompraProduto::create($this->prepararDadosCompra($data));

        return redirect()->route('compras-produtos.index')
            ->with('success', 'Compra registrada com sucesso.');
    }

    public function edit(CompraProduto $compras_produto)
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        $compraProduto = $compras_produto;

        return view('compras-produtos.form', compact('compraProduto', 'clientes', 'produtos'));
    }

    public function show(CompraProduto $compras_produto)
    {
        return redirect()->route('compras-produtos.index');
    }

    public function update(Request $request, CompraProduto $compras_produto)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:cliente,id',
            'produto_id' => 'required|exists:produtos,id',
            'fornecedor' => 'required',
            'quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric',
            'data_compra' => 'required|date',
            'observacao' => 'nullable',
        ]);

        $compras_produto->update($this->prepararDadosCompra($data));

        return redirect()->route('compras-produtos.index')
            ->with('success', 'Compra atualizada com sucesso.');
    }

    public function destroy(CompraProduto $compras_produto)
    {
        $compras_produto->delete();

        return redirect()->route('compras-produtos.index')
            ->with('success', 'Compra removida com sucesso.');
    }

    public function chart(LarapexChart $chart)
    {
        return view('compras-produtos.chart', [
            'chart' => $this->produtoMaisCompradoChart($chart)
        ]);
    }

    private function prepararDadosCompra(array $data): array
    {

        return $data;
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
