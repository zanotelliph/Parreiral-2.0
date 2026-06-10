@extends('main')

@section('titulo', 'Painel de Gestão')

@section('conteudo')
<div class="py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Painel de Gestão</h1>
            <p class="text-muted mb-0">Acesse rapidamente os módulos do sistema.</p>
        </div>


    <div class="row g-4">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text text-muted">Gerencie cadastros de clientes e mantenha seus registros organizados.</p>
                    <a href="{{ route('cliente.index') }}" class="btn btn-primary">Abrir clientes</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Produtos</h5>
                    <p class="card-text text-muted">Cadastre, edite e visualize os produtos disponíveis no catálogo.</p>
                    <a href="{{ route('produto.index') }}" class="btn btn-outline-primary">Abrir produtos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Reservas de Eventos</h5>
                    <p class="card-text text-muted">Controle reservas, status e organização dos eventos.</p>
                    <a href="{{ route('reservas-eventos.index') }}" class="btn btn-outline-primary">Abrir reservas</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Compras de Produtos</h5>
                    <p class="card-text text-muted">Acompanhe as compras realizadas e seus registros de movimentação.</p>
                    <a href="{{ route('compras-produtos.index') }}" class="btn btn-outline-primary">Abrir compras</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Estoque</h5>
                    <p class="card-text text-muted">Visualize e mantenha o controle de entradas e saldo dos itens.</p>
                    <a href="{{ route('estoques.index') }}" class="btn btn-outline-primary">Abrir estoque</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Eventos</h5>
                    <p class="card-text text-muted">Cadastre agenda, limites e valores dos eventos disponíveis.</p>
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-primary">Abrir eventos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h5 class="card-title">Resumo</h5>
                    <p class="card-text text-muted mb-3">Aqui você consegue navegar por todos os módulos criados no projeto.</p>
                    <ul class="small text-muted mb-0 ps-3">
                        <li>Cliente</li>
                        <li>Produto</li>
                        <li>Reservas</li>
                        <li>Compras</li>
                        <li>Estoque</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
