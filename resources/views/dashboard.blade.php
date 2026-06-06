@extends('main')

@section('titulo', 'Painel de Gestão')

@section('conteudo')
<div class="page-hero page-hero-dashboard">
    <h1 class="h3">Painel de Gestão</h1>
    <p>Visão geral da vinícola — clientes, vendas, estoque e parreiral.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-parreiral stat-card h-100">
            <div class="card-body">
                <p class="stat-label mb-1">Total de clientes</p>
                <p class="stat-value mb-0">{{ $totalClientes }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-parreiral-gold stat-card h-100">
            <div class="card-body">
                <p class="stat-label mb-1">Compras registradas</p>
                <p class="stat-value mb-0">{{ $totalCompras }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-parreiral-vine stat-card h-100">
            <div class="card-body">
                <p class="stat-label mb-1">Valor total em compras</p>
                <p class="stat-value mb-0">R$ {{ number_format($valorTotalCompras, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card card-parreiral h-100">
            <div class="card-body">
                <h5 class="card-title">Compras por mês ({{ now()->year }})</h5>
                <p class="text-muted small">Valor total das compras realizadas em cada mês.</p>
                <canvas id="graficoCompras" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-parreiral-gold h-100">
            <div class="card-body">
                <h5 class="card-title">Clientes por status financeiro</h5>
                <p class="text-muted small">Distribuição dos clientes entre em dia e pendente.</p>
                <canvas id="graficoClientes" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-parreiral h-100">
            <div class="card-body">
                <span class="module-icon">📊</span>
                <h5 class="card-title">Relatório de Compras</h5>
                <p class="card-text text-muted">Filtre compras por período e cliente com totais consolidados.</p>
                <a href="{{ route('relatorios.compras') }}" class="btn btn-outline-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-parreiral-gold h-100">
            <div class="card-body">
                <span class="module-icon">👥</span>
                <h5 class="card-title">Relatório de Clientes</h5>
                <p class="card-text text-muted">Identificadores únicos, status e histórico de compras.</p>
                <a href="{{ route('relatorios.clientes') }}" class="btn btn-outline-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-parreiral-vine h-100">
            <div class="card-body">
                <span class="module-icon">🧑‍🤝‍🧑</span>
                <h5 class="card-title">Clientes</h5>
                <p class="card-text text-muted">Cadastros e relacionamento com a vinícola.</p>
                <a href="{{ route('cliente.index') }}" class="btn btn-primary">Abrir clientes</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-parreiral h-100">
            <div class="card-body">
                <span class="module-icon">🍷</span>
                <h5 class="card-title">Produtos</h5>
                <p class="card-text text-muted">Catálogo de vinhos, sucos e derivados da uva.</p>
                <a href="{{ route('produto.index') }}" class="btn btn-outline-primary">Abrir produtos</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-parreiral-gold h-100">
            <div class="card-body">
                <span class="module-icon">🛒</span>
                <h5 class="card-title">Compras de Produtos</h5>
                <p class="card-text text-muted">Movimentações vinculadas aos clientes.</p>
                <a href="{{ route('compras-produtos.index') }}" class="btn btn-outline-primary">Abrir compras</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-parreiral-vine h-100">
            <div class="card-body">
                <span class="module-icon">📦</span>
                <h5 class="card-title">Estoque</h5>
                <p class="card-text text-muted">Controle de garrafas e insumos do parreiral.</p>
                <a href="{{ route('estoques.index') }}" class="btn btn-outline-primary">Abrir estoque</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const wineColors = {
        burgundy: 'rgba(139, 42, 58, 0.85)',
        burgundyBorder: 'rgba(107, 31, 46, 1)',
        gold: 'rgba(201, 169, 97, 0.9)',
        vine: 'rgba(74, 124, 78, 0.9)',
        cream: 'rgba(139, 115, 90, 0.7)',
    };

    new Chart(document.getElementById('graficoCompras'), {
        type: 'bar',
        data: {
            labels: @json($comprasLabels),
            datasets: [{
                label: 'Valor (R$)',
                data: @json($comprasValores),
                backgroundColor: wineColors.burgundy,
                borderColor: wineColors.burgundyBorder,
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(107, 31, 46, 0.08)' },
                    ticks: {
                        color: '#6b5344',
                        callback: (value) => 'R$ ' + value.toLocaleString('pt-BR')
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#6b5344' }
                }
            }
        }
    });

    new Chart(document.getElementById('graficoClientes'), {
        type: 'doughnut',
        data: {
            labels: @json($clientesStatusLabels),
            datasets: [{
                data: @json($clientesStatusValores),
                backgroundColor: [wineColors.vine, wineColors.burgundy, wineColors.gold, wineColors.cream],
                borderColor: '#fdfbf7',
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#6b5344', font: { family: 'Source Sans 3' } }
                }
            }
        }
    });
</script>
@endpush
