# Desafio tray de vendas e comissões

## Instalação

### Pré-requisitos

- Docker and Docker Compose instalados

### Configuração

1. **Clone o repositório**
   ```bash
   git clone https://github.com/{seu_username}/tray-comissions-challenge-backend.git
   cd tray-comissions-challenge-backend
   ```

2. **Crie um arquivo `.env` baseado no `.env.example`**
    ```bash
    cp .env.example .env
    ```

3. **Configure as variáveis de banco de dados no `.env`**
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=tray_challenge
    DB_USERNAME=user
    DB_PASSWORD=password
    ```

### Execução do projeto
1. **Inicie os containers**
   ```bash
   docker-compose up -d --build
   ```

2. **Execute as migrations e as seeders**
   ```bash
   docker-compose exec web php artisan migrate
   docker-compose exec web php artisan db:seed --class=DatabaseSeeder
   ```
   ps: Se a migration falhar, espere um pouco antes de rodar, pois o banco pode ainda não ter sido inicializado corretamente.

   As seeders irão criar 1 usuário admin, 10 vendedores, 200 vendas para os vendedores e 1 configuração de comissão (padrão 8.5%).

## API endpoints

A API estará disponível em `http://localhost:9000`

### Autenticação

* `POST /api/login`: Recebe os dados: `login` e `password` e retorna o usuário logado e o `token` de autenticação para API.
* `POST /api/logout`: Recebe os dados: `login` e `password` e desloga o usuário que estava logado.

### Vendedores

* `POST /api/v1/seller`: Recebe os dados: `name` e `email`e retorna o vendedor criado.
* `GET /api/v1/seller`: Retorna todos os vendedores existentes.
* `GET /api/v1/seller/{id}`: Retorna um vendedor específico de acordo com a `id`.
* `GET /api/v1/seller/{id}/sale`: Retorna todas as vendas de um vendedor específico.
* `POST /api/v1/seller/{id}/resend-report`: Recebe o dado: `date` e reenvia o e-mail de comissão de vendas de uma data específica para um vendedor.

### Venda

* `POST /api/v1/sale`: Recebe os dados: `seller_id`, `value` e `sale_date` e retorna a venda criada.
* `GET /api/v1/sale`: Retorna todas as vendas criadas.
* `GET /api/v1/sale/{id}`: Retorna uma venda específica de acordo com a `id`.

### Configuração

* `PUT /api/v1/configuration/{id}`: Recebe os dados: `key` e `value` e retorna a nova configuração atualizada.

### Envio de e-mails

1. **Rode a queue**
   ```bash
   docker-compose exec web php artisan queue:work
   ```

2. **Rode o schedule**
    ```bash
   docker-compose exec web php artisan schedule:work
   ```
   ps: O schedule está marcado para rodar diariamente as 23:55, você pode forçar o `command` para rodar usando:
   ```bash
   docker-compose exec web php artisan app:send-daily-reports
   ```

Após isso a job irá rodar e enviar os e-mails para os vendedores que fizeram vendas no dia atual, além de um e-mail com relatório para o admin
Para checar os e-mails você pode acessar o serviço do Mailhog entrando na url: http://localhost:8025/.

### Otimizações
* As APIs são cacheadas com Redis para aumentar a performance das requisições.
* O envio de e-mails é utilizado com filas para efetuar o processamento assíncrono.
* As operações de `create` e `update` no banco de dados foram enclausuradas por `transactions` para garantir a segurança do banco.
* Utilização de índices para `seller_id`, `sale_date` e `reported` para otimizar as queries no banco de dados.

