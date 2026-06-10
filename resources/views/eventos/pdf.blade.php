<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Eventos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h1>Relatório de Eventos</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Início</th>
        <th>Término</th>
        <th>Limite</th>
        <th>Valor 1</th>
        <th>Valor 2</th>
        <th>Valor 3</th>
    </tr>

    @foreach($eventos as $evento)
    <tr>
        <td>{{ $evento->id }}</td>
        <td>{{ $evento->nome_evento }}</td>
        <td>{{ $evento->descricao ?? '-' }}</td>
        <td>{{ $evento->data_inicio }} {{ $evento->hora_inicio }}</td>
        <td>{{ $evento->data_fim }} {{ $evento->hora_fim }}</td>
        <td>{{ $evento->limite_pessoas ?? '-' }}</td>
        <td>R$ {{ number_format($evento->valor_ingresso_1 ?? 0, 2, ',', '.') }}</td>
        <td>R$ {{ number_format($evento->valor_ingresso_2 ?? 0, 2, ',', '.') }}</td>
        <td>R$ {{ number_format($evento->valor_ingresso_3 ?? 0, 2, ',', '.') }}</td>
    </tr>
    @endforeach
</table>
</body>
</html>