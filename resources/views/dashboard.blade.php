@extends('main')

@section('titulo', 'Painel de Gestão')

@section('conteudo')
<div class="py-4">

    <div class="page-hero page-hero-dashboard mb-2">
        <p>Sistema de gestão empresarial.</p>
    </div>

        <div class="col-md-1">
            <div class="card card-parreiral-gold stat-card h-60">
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
                    <p class="stat-value mb-0">
                        R$ {{ number_format($valorTotalCompras, 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card card-parreiral h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        Produtos mais comprados ({{ now()->year }})
                    </h5>


                    <canvas id="graficoCompras" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-parreiral-gold h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        Eventos mais acessados.
                    </h5>

                    <p class="text-muted small">
                        Distribuição dos clientes entre em dia e pendente.
                    </p>

                    <canvas id="graficoClientes" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-parreiral h-100">
                <div class="card-body">
                    <span class="module-icon"></span>
                    <h5 class="card-title">Relatório de Produtos mais comprados</h5>

                    <p class="card-text text-muted">
                        Ordem de produtos que masi despertam interesse nos consumidores.
                    </p>

                    <a href="{{ route('relatorios.compras') }}"
                        class="btn btn-outline-primary">
                        Acessar relatório
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-parreiral-gold h-100">
                <div class="card-body">
                    <span class="module-icon"></span>
                    <h5 class="card-title">Relatório de Eventos mais acessados</h5>

                    <p class="card-text text-muted">
                        Eventos com maior público.
                    </p>

                    <a href="{{ route('relatorios.clientes') }}"
                        class="btn btn-outline-primary">
                        Acessar relatório
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-parreiral-vine h-100">
                <div class="card-body">
                    <span class="module-icon"></span>
                    <h5 class="card-title">Clientes</h5>

                    <p class="card-text text-muted">
                        Cadastros e relacionamento com a vinícola.
                    </p>

                    <a href="{{ route('cliente.index') }}"
                        class="btn btn-primary">
                        Acessar clientes
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-parreiral h-100">
                <div class="card-body">
                    <span class="module-icon"></span>
                    <h5 class="card-title">Produtos</h5>

                    <p class="card-text text-muted">
                        Catálogo de vinhos, sucos e derivados da uva.
                    </p>

                    <a href="{{ route('produto.index') }}"
                        class="btn btn-outline-primary">
                        Acessar produtos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-parreiral-gold h-100">
                <div class="card-body">
                    <span class="module-icon"></span>
                    <h5 class="card-title">Compras de Produtos</h5>

                    <p class="card-text text-muted">
                        Movimentações vinculadas aos clientes.
                    </p>

                    <a href="{{ route('compras-produtos.index') }}"
                        class="btn btn-outline-primary">
                        Acessar compras
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-parreiral-vine h-100">
                <div class="card-body">
                    <span class="module-icon"></span>
                    <h5 class="card-title">Estoque</h5>

                    <p class="card-text text-muted">
                        Controle de garrafas e insumos do parreiral.
                    </p>

                    <a href="{{ route('estoques.index') }}"
                        class="btn btn-outline-primary">
                        Acesse aquo
                    </a>
                </div>
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

const graficoCompras = document.getElementById('graficoCompras');

if (graficoCompras) {
    new Chart(graficoCompras, {
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
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(107, 31, 46, 0.08)'
                    },
                    ticks: {
                        color: '#6b5344'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b5344'
                    }
                }
            }
        }
    });
}

const graficoClientes = document.getElementById('graficoClientes');

if (graficoClientes) {
    new Chart(graficoClientes, {
        type: 'doughnut',
        data: {
            labels: @json($clientesStatusLabels),
            datasets: [{
                data: @json($clientesStatusValores),
                backgroundColor: [
                    wineColors.vine,
                    wineColors.burgundy,
                    wineColors.gold,
                    wineColors.cream
                ],
                borderColor: '#fdfbf7',
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6b5344'
                    }
                }
            }
        }
    });
}
</script>
@endpush