<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index()
    {
        $clientes = Cliente::all();

        return view('cliente.list', [
            'clientes' => $clientes
        ]);
    }

    public function create()
    {
        return view('cliente.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'telefone' => 'required|max:20',
            'email' => 'required|email|unique:clientes,email',
            'endereco' => 'required|max:200',
            'preferenciasCompra' => 'nullable',
            'historicoVisitas' => 'nullable',
            'identificadorUnico' => 'required|unique:clientes,identificadorUnico'
        ]);

        Cliente::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'endereco' => $request->endereco,
            'preferenciasCompra' => $request->preferenciasCompra,
            'historicoVisitas' => $request->historicoVisitas,
            'identificadorUnico' => $request->identificadorUnico
        ]);

        return redirect('/cliente');
    }

    public function show(Cliente $cliente)
    {
        return view('cliente.show', [
            'cliente' => $cliente
        ]);
    }


    public function edit(Cliente $cliente)
    {
        return view('cliente.form', [
            'cliente' => $cliente
        ]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'telefone' => 'required|max:20',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'endereco' => 'required|max:200',
            'preferenciasCompra' => 'nullable',
            'historicoVisitas' => 'nullable',
            'identificadorUnico' => 'required|unique:clientes,identificadorUnico,' . $cliente->id
        ]);

        $cliente->update([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'endereco' => $request->endereco,
            'preferenciasCompra' => $request->preferenciasCompra,
            'historicoVisitas' => $request->historicoVisitas,
            'identificadorUnico' => $request->identificadorUnico
        ]);

        return redirect('/cliente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect('/cliente');
    }
}
