<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Parreiral') — Vinícola</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/parreiral.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-parreiral sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="brand-icon" aria-hidden="true">🍷</span>
                Parreiral
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Painel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cliente.index') }}">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('produto.index') }}">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservas-eventos.index') }}">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('eventos.index') }}">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('compras-produtos.index') }}">Compras</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('estoques.index') }}">Estoque</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Informações de ADM</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('relatorios.compras') }}">Compras</a></li>
                            <li><a class="dropdown-item" href="{{ route('relatorios.clientes') }}">Clientes</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            @yield('conteudo')
        </div>
    </main>

    <footer class="footer-parreiral">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <span class="footer-brand">🍇 Parreiral — Gestão de Vinícola</span>
                <small>Tradição, uva e excelência no copo</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        function previewImagem(input, previewId) {
            const preview = document.getElementById(previewId);
            if (!preview || !input.files || !input.files[0]) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
    @stack('scripts')
</body>
</html>
