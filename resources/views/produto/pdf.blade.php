<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h1>Relatório de Produtos</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
    </tr>

    @foreach($produtos as $produto)
    <tr>
        <td>{{ $produto->id }}</td>
        <td>{{ $produto->nome }}</td>
        <td>{{ $produto->categoria_produto }}</td>
        <td>R$ {{ number_format($produto->preco_produto ?? 0, 2, ',', '.') }}</td>
    </tr>
    @endforeach
</table>
</body>
</html>