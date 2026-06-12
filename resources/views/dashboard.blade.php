@extends('main')

@section('titulo', 'Painel de Gestão')

@section('conteudo')
<div class="py-4 dashboard-dark">

    <div class="page-hero page-hero-dashboard mb-4">
        <h2 class="text-white m-0">Sistema de Gestão Empresarial</h2>
        <p class="text-white small">Acompanhamento de vendas, relatório de eventos e compras, estoque e clientes.</p>
    </div>

    //relatorios

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card form-card-dark h-100">
                <div class="card-body">
                    <h5 class="card-title text-white mb-3">Filtros & Consultas Rápidas</h5>
                    
                    <form action="#" method="GET">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Selecione o Período</label>
                            <select class="form-select form-control-dark">
                                <option>Últimos 7 dias</option>
                                <option>Últimos 30 dias</option>
                                <option>Este mês</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Buscar por Cliente</label>
                            <input type="text" class="form-control form-control-dark" placeholder="Nome ou CPF...">
                        </div>
                        <button type="submit" class="btn btn-neon-green w-100">Filtrar Painel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card form-card-dark h-100">
                <div class="card-body">
                    <h5 class="card-title text-white mb-3">Atalhos do Sistema</h5>
                    <div class="list-group list-group-flush dark-list">
                        <a href="{{ route('relatorios.compras') }}" class="list-group-item d-flex justify-content-between align-items-center">
                            <span>1. Relatório de Compras</span>
                            <span class="badge bg-secondary rounded-pill">Acessar</span>
                        </a>
                        <a href="{{ route('cliente.index') }}" class="list-group-item d-flex justify-content-between align-items-center">
                            <span>2. Gerenciar Clientes</span>
                            <span class="badge bg-secondary rounded-pill">Acessar</span>
                        </a>
                        <a href="{{ route('produto.index') }}" class="list-group-item d-flex justify-content-between align-items-center">
                            <span>3. Catálogo de Produtos</span>
                            <span class="badge bg-secondary rounded-pill">Acessar</span>
                        </a>
                        <a href="{{ route('estoques.index') }}" class="list-group-item d-flex justify-content-between align-items-center">
                            <span>4. Controle de Estoque</span>
                            <span class="badge bg-secondary rounded-pill">Acessar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@endpush