<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Clientes Cadastrados</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11pt;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 5px;
            font-size: 18pt;
        }
        .subtitle {
            text-align: center;
            font-size: 10pt;
            color: #666;
            margin-bottom: 25px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 9.5pt;
        }
        th, td { 
            border: 1px solid #999; 
            padding: 8px 6px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            color: #000;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8.5pt;
            font-weight: bold;
        }
        .badge-sim { background-color: #d4edda; color: #155724; }
        .badge-nao { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<h1>Relatório de Clientes Cadastrados</h1>
<div class="subtitle">Gerado em: {{ date('d/m/Y H:i') }} | Total de registros: {{ $clientes->count() }}</div>

<table>
    <thead>
        <tr>
            <th width="5%" class="text-center">ID</th>
            <th width="25%">Nome</th>
            <th width="25%">E-mail</th>
            <th width="15%">Telefone</th>
            <th width="15%">CPF</th>
            <th width="15%">Status Fin.</th>
            <th width="10%" class="text-center">Fidelizado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td class="text-center">{{ $cliente->id }}</td>
            <td><strong>{{ $cliente->nome }}</strong></td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->telefone }}</td>
            <td>{{ $cliente->cpf }}</td>
            <td>{{ $cliente->status_financeiro }}</td>
            <td class="text-center">
                @if($cliente->cliente_fidelizado)
                    <span class="badge badge-sim">Sim</span>
                @else
                    <span class="badge badge-nao">Não</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>