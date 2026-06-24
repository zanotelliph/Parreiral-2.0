<?php

namespace App\Http\Controllers;

use App\Charts\MaiorCliente;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cliente;
use FFI\CData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// variáveis: $dados = coleção de clientes, $dado = cliente específico, $q = termo de busca, $id = identificador do cliente
// request = contem os dados http como cabeçalhos
// $cliente: registro específico do cliente, $data: array de dados do cliente, $request: objeto de solicitação HTTP 
class ClienteController extends Controller
{
    public function index() 
    {
        $q = trim(request('q', '')); 

        $dados = Cliente::query() 
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nome', 'like', "%{$q}%") 
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('telefone', 'like', "%{$q}%")
                    ->orWhere('cpf', 'like', "%{$q}%");
            })
            ->orderBy('nome') 
            ->get();

        return view('cliente.list', compact('dados', 'q')); 
    }

    public function create()
    {
        return view('cliente.form', [ // reutilizar a mesma view para criar e editar
            'dado' => new Cliente()
        ]);
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'nullable|date',
            'email' => 'required|email',
            'telefone' => 'required|string|max:20',

            'cpf' => 'required|string|max:16',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',

            'cep' => 'nullable|string|max:10',
            //'endereco' => 'nullable|string|max:300',
            'data_cadastro' => 'required|date',
            'status_financeiro' => 'required|string|max:50',
            'rua' => 'nullable|string|max:300',
            'numero' => 'nullable|string|max:50',
            'complemento' => 'nullable|string|max:300',
            'bairro' => 'nullable|string|max:300',
            'cidade' => 'nullable|string|max:300',
            'estado' => 'nullable|string|max:2',
            'preferenciadecompra' => 'nullable|string|max:500',
            'observacoes' => 'nullable|string',
            'numero_visitas' => 'nullable|integer|min:0',
            'data_ultima_visita' => 'nullable|date',
            'cliente_fidelizado' => 'required|boolean',
            'nivel_fidelidade' => 'nullable|integer|min:0|max:2',
        ], [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'telefone.required' => 'O telefone é obrigatório',
            'cpf.required' => 'O CPF é obrigatório',
            'data_cadastro.required' => 'A data de cadastro é obrigatória',
            'status_financeiro.required' => 'O status financeiro é obrigatório',
            'cliente_fidelizado.required' => 'O campo cliente fidelizado é obrigatório',
            'imagem.image' => 'Arquivo inválido de imagem',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->only([
            'nome',
            'data_nascimento',
            'email',
            'telefone',
            'cpf',
            'endereco',
            'cep',
            'data_cadastro',
            'status_financeiro',
            'rua',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'preferenciadecompra',
            'observacoes',
            'numero_visitas',
            'data_ultima_visita',
            'cliente_fidelizado',
            'nivel_fidelidade',
            'historicodevisitas'
        ]);

        if ($request->hasFile('imagem')) { 
            $data['imagem'] = $request->file('imagem') 
                ->store('imagem/cliente', 'public');
        }

        Cliente::create($data); // insere os registros no banco de clientes

        return redirect('cliente')
            ->with('success', 'Registro cadastrado com sucesso!'); //balão 
    }

    public function edit($id) 
    {
        $dado = Cliente::findOrFail($id);

        return view('cliente.form', compact('dado')); // campos existentes preenchidos com dados anteriores
    }

    public function update(Request $request, $id)// os dados do cliente tem como parametro o id
    {
        $this->validateRequest($request); 

        $cliente = Cliente::findOrFail($id); 

        $data = $request->only([
            'nome',
            'data_nascimento',
            'email',
            'telefone',
            'cpf',
            'endereco',
            'cep',
            'data_cadastro',
            'status_financeiro',
            'rua',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'preferenciadecompra',
            'observacoes',
            'numero_visitas',
            'data_ultima_visita',
            'cliente_fidelizado',
            'nivel_fidelidade',
            'historicodevisitas'
        ]);

        if ($request->hasFile('imagem')) {

            if ($cliente->imagem) {
                Storage::disk('public')->delete($cliente->imagem); // classe de gerenciamento de arquivos do laravel 
            }

            $data['imagem'] = $request->file('imagem')
                ->store('imagem/cliente', 'public');
        }

        $cliente->update($data);

        return redirect('cliente')
            ->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id); // DE NOVO???

        if ($cliente->imagem) {
            Storage::disk('public')->delete($cliente->imagem);
        }

        $cliente->delete();

        return redirect('cliente')
            ->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {  

            $dados = Cliente::where( 
                $request->tipo, 
                'like',
                '%' . $request->valor . '%' 
            )->get();

        } else {

            $dados = Cliente::all();
        }

        return view('cliente.list', [ 
            'dados' => $dados
        ]);
    }
public function pdf()
{
    
    $clientes = Cliente::all();

    $pdf = Pdf::loadView('cliente.pdf', compact('clientes'));

    return $pdf->download('cliente.pdf');
}
}
