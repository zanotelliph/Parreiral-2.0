<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteIdentificador;
use App\Models\CompraProduto;
use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class ParreiralSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = collect([
            ['nome' => 'Vinho Tinto Reserva', 'categoria_produto' => 'Tinto', 'tipo_uva' => 'Cabernet', 'preco' => 89.90, 'quantidade_disponivel' => 120],
            ['nome' => 'Vinho Branco Suave', 'categoria_produto' => 'Branco', 'tipo_uva' => 'Moscato', 'preco' => 59.90, 'quantidade_disponivel' => 80],
            ['nome' => 'Espumante Brut', 'categoria_produto' => 'Espumante', 'tipo_uva' => 'Chardonnay', 'preco' => 74.50, 'quantidade_disponivel' => 60],
            ['nome' => 'Suco de Uva Integral', 'categoria_produto' => 'Suco', 'tipo_uva' => 'Bordô', 'preco' => 24.90, 'quantidade_disponivel' => 200],
        ])->map(fn (array $data) => Produto::create($data));

        $clientes = [
            ['nome' => 'Ana Silva', 'email' => 'ana@email.com', 'telefone' => '(11) 99999-1111', 'cpf' => '111.111.111-11', 'endereco' => 'Rua das Uvas, 100 - Centro', 'status_financeiro' => 'em dia', 'data_cadastro' => now()->subMonths(6)->toDateString(), 'codigo' => 'CLI-0001'],
            ['nome' => 'Bruno Costa', 'email' => 'bruno@email.com', 'telefone' => '(11) 99999-2222', 'cpf' => '222.222.222-22', 'endereco' => 'Av. Vinícola, 250 - Jardins', 'status_financeiro' => 'pendente', 'data_cadastro' => now()->subMonths(3)->toDateString(), 'codigo' => 'CLI-0002'],
            ['nome' => 'Carla Mendes', 'email' => 'carla@email.com', 'telefone' => '(11) 99999-3333', 'cpf' => '333.333.333-33', 'endereco' => 'Rua Parreiral, 45 - Vila Nova', 'status_financeiro' => 'em dia', 'data_cadastro' => now()->subMonth()->toDateString(), 'codigo' => 'CLI-0003'],
        ];

        foreach ($clientes as $index => $dadosCliente) {
            $codigo = $dadosCliente['codigo'];
            unset($dadosCliente['codigo']);

            $cliente = Cliente::create($dadosCliente);

            ClienteIdentificador::create([
                'cliente_id' => $cliente->id,
                'codigo_externo' => $codigo,
                'tipo_documento' => 'cpf',
                'documento' => $cliente->cpf,
            ]);

            CompraProduto::create([
                'cliente_id' => $cliente->id,
                'produto_id' => $produtos[$index % $produtos->count()]->id,
                'fornecedor' => 'Vinícola Parreiral',
                'quantidade' => 2 + $index,
                'valor_total' => (2 + $index) * $produtos[$index % $produtos->count()]->preco,
                'data_compra' => now()->subMonths($index + 1)->startOfMonth()->addDays(5),
                'observacao' => 'Compra de demonstração',
            ]);

            CompraProduto::create([
                'cliente_id' => $cliente->id,
                'produto_id' => $produtos[($index + 1) % $produtos->count()]->id,
                'fornecedor' => 'Distribuidora Sul',
                'quantidade' => 1,
                'valor_total' => $produtos[($index + 1) % $produtos->count()]->preco,
                'data_compra' => now()->subDays(10 + $index),
                'observacao' => 'Reposição mensal',
            ]);
        }

        foreach ($produtos as $index => $produto) {
            Estoque::create([
                'produto_id' => $produto->id,
                'quantidade' => $produto->quantidade_disponivel,
                'lote' => 'L' . now()->format('Y') . ($index + 1),
                'localizacao' => 'Depósito A',
                'status' => $index % 2 === 0 ? 'disponivel' : 'baixo',
            ]);
        }
    }
}
