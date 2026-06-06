<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('titulo')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; margin: 24px; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .subtitulo { color: #666; margin: 0 0 16px; font-size: 11px; }
        .meta { margin-bottom: 16px; }
        .meta span { display: inline-block; margin-right: 16px; }
        .resumo { margin-bottom: 16px; }
        .resumo-box { display: inline-block; width: 30%; padding: 8px 12px; border: 1px solid #ddd; margin-right: 2%; vertical-align: top; }
        .resumo-box strong { display: block; font-size: 14px; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #333; color: #fff; font-size: 10px; }
        tr:nth-child(even) { background: #f8f8f8; }
        tfoot td { font-weight: bold; background: #eee; }
        .vazio { text-align: center; color: #888; padding: 20px; }
        .rodape { margin-top: 20px; font-size: 9px; color: #888; text-align: right; }
    </style>
</head>
<body>
    @yield('conteudo')
    <div class="rodape">Gerado em {{ $geradoEm }} — Parreiral</div>
</body>
</html>
