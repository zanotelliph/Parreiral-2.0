p# Sistema de Cadastro e Controle — Laravel

Sistema web desenvolvido em **Laravel 11 + Blade + Alpine.js + Tailwind CSS** para gerenciamento de clientes e movimentações financeiras.

---

## Stack

| Camada      | Tecnologia                         |
|-------------|------------------------------------|
| Backend     | PHP 8.2+ / Laravel 11              |
| Views       | Blade Templates                    |
| Interações  | Alpine.js 3.x (sem build step)     |
| Gráficos    | Chart.js (CDN)                     |
| Banco       | MySQL / PostgreSQL / SQLite        |

---

## Instalação

### 1. Pré-requisitos
- PHP >= 8.2
- Composer
- MySQL ou PostgreSQL (ou SQLite para desenvolvimento)

### 2. Criar projeto Laravel e copiar arquivos

```bash
composer create-project laravel/laravel sistema-cadastro
cd sistema-cadastro
```

Copie os arquivos deste pacote para dentro do projeto substituindo os existentes:
- `app/Http/Controllers/` → controllers
- `app/Models/` → models
- `resources/views/` → views
- `database/migrations/` → migrations
- `routes/web.php` → rotas

### 3. Configurar o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o `.env` com suas credenciais de banco:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_cadastro
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

Para usar **SQLite** (mais simples para dev):
```env
DB_CONNECTION=sqlite
# apague as outras linhas DB_*
```
```bash
touch database/database.sqlite
```

### 4. Executar migrations e seed

```bash
php artisan migrate
php artisan db:seed
```

### 5. Iniciar o servidor

```bash
php artisan serve
```

Acesse: **http://localhost:8000**

---

## Estrutura de Views

```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout principal (sidebar + topbar)
├── partials/
│   └── pagination.blade.php   # Paginação customizada
├── dashboard.blade.php         # Dashboard com gráficos
├── cadastros/
│   ├── index.blade.php         # Listagem de clientes
│   ├── create.blade.php        # Formulário de criação
│   ├── edit.blade.php          # Formulário de edição
│   ├── show.blade.php          # Detalhes do cliente
│   └── form.blade.php          # Form compartilhado
├── controles/
│   ├── index.blade.php         # Listagem de movimentações
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── form.blade.php
└── relatorios/
    └── index.blade.php         # Relatórios com gráficos + exportação
```

---

## Rotas disponíveis

| Método | URL                  | Nome                  | Descrição               |
|--------|----------------------|-----------------------|-------------------------|
| GET    | /                    | dashboard             | Dashboard               |
| GET    | /cadastros           | cadastros.index       | Listar clientes         |
| GET    | /cadastros/create    | cadastros.create      | Formulário de criação   |
| POST   | /cadastros           | cadastros.store       | Salvar novo cliente     |
| GET    | /cadastros/{id}      | cadastros.show        | Ver cliente             |
| GET    | /cadastros/{id}/edit | cadastros.edit        | Formulário de edição    |
| PUT    | /cadastros/{id}      | cadastros.update      | Atualizar cliente       |
| DELETE | /cadastros/{id}      | cadastros.destroy     | Excluir cliente         |
| GET    | /controles           | controles.index       | Listar movimentações    |
| POST   | /controles           | controles.store       | Salvar movimentação     |
| ...    | ...                  | ...                   | (mesmo padrão)          |
| GET    | /relatorios          | relatorios.index      | Relatórios              |
| GET    | /relatorios/exportar | relatorios.exportar   | Exportar CSV            |

---

## Funcionalidades

- ✅ CRUD completo de Clientes
- ✅ CRUD completo de Movimentações (entradas/saídas)
- ✅ Dashboard com gráficos (Chart.js)
- ✅ Filtros e busca em todas as listagens
- ✅ Paginação customizada
- ✅ Exportação de relatórios em CSV
- ✅ Soft Delete (registros não são apagados fisicamente)
- ✅ Flash messages de sucesso/erro
- ✅ Validação server-side com mensagens em português
- ✅ Sidebar recolhível (Alpine.js)
- ✅ Modo escuro (Dark Mode)
- ✅ Responsivo (mobile-friendly)
