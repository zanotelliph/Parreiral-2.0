<?php

namespace Database\Seeders;

use App\Models\Cadastro;
use App\Models\Controle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clientes de exemplo
        $clientes = [
            ['nome' => 'Ana Paula Ferreira',  'email' => 'ana.ferreira@email.com',  'telefone' => '(49) 99811-1111', 'documento' => '123.456.789-00', 'cidade' => 'Chapecó',    'estado' => 'SC', 'ativo' => true],
            ['nome' => 'Bruno Costa',          'email' => 'bruno.costa@email.com',   'telefone' => '(49) 99822-2222', 'documento' => '234.567.890-11', 'cidade' => 'Xanxerê',    'estado' => 'SC', 'ativo' => true],
            ['nome' => 'Carla Mendes',         'email' => 'carla.mendes@email.com',  'telefone' => '(49) 99833-3333', 'documento' => '345.678.901-22', 'cidade' => 'Concórdia',   'estado' => 'SC', 'ativo' => true],
            ['nome' => 'Diego Santos',         'email' => 'diego.santos@email.com',  'telefone' => '(41) 99844-4444', 'documento' => '456.789.012-33', 'cidade' => 'Curitiba',    'estado' => 'PR', 'ativo' => false],
            ['nome' => 'Elisa Rodrigues',      'email' => 'elisa.rod@email.com',     'telefone' => '(51) 99855-5555', 'documento' => '567.890.123-44', 'cidade' => 'Porto Alegre','estado' => 'RS', 'ativo' => true],
        ];

        foreach ($clientes as $dados) {
            Cadastro::create($dados);
        }

        // Movimentações de exemplo
        $cadastros = Cadastro::all();
        $tipos     = ['entrada', 'saida'];
        $status    = ['pendente', 'concluido', 'concluido', 'concluido'];
        $descricoes = [
            'Pagamento de serviço', 'Compra de material', 'Venda de produto',
            'Taxa administrativa', 'Recebimento de cliente', 'Despesa operacional',
        ];

        for ($i = 0; $i < 20; $i++) {
            Controle::create([
                'descricao'   => $descricoes[array_rand($descricoes)],
                'tipo'        => $tipos[array_rand($tipos)],
                'valor'       => round(rand(50, 5000) + rand(0, 99) / 100, 2),
                'status'      => $status[array_rand($status)],
                'cadastro_id' => $cadastros->random()->id,
                'created_at'  => now()->subDays(rand(0, 60)),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('✓ Dados de exemplo criados com sucesso!');
    }
}
