# Projeto Backend de Cadastro de Usuários e Produtos

Este projeto é um backend desenvolvido em Laravel, com suporte para o cadastro, edição, e deleção de produtos e usuários. Ele utiliza autenticação com Laravel Sanctum para proteger as rotas.

## Índice

- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Funcionalidades](#funcionalidades)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Executando a Aplicação](#executando-a-aplicação)
- [Rotas Disponíveis](#rotas-disponíveis)

## Tecnologias Utilizadas

- [Laravel 11](https://laravel.com/)
- [MySQL](https://www.mysql.com/)
- [PHP 8.2](https://www.php.net/releases/8.2/en.php)
- [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum) - para autenticação
- [Postman](https://www.postman.com/) - para testes de API

## Funcionalidades

- Cadastro de usuários com autenticação
- Edição e remoção de produtos
- Proteção de rotas com autenticação via Sanctum
- Validação de dados ao cadastrar e editar
- Senhas criptografadas no banco de dados com Hash

## Instalação

### Pré-requisitos

- PHP >= 8.2
- Composer
- MySQL
- Git

### Passo a Passo

1. Clone o repositório:

    ```bash
    git clone https://github.com/Tjaos/api_laravel_test.git
    ```

2. Entre no diretório do projeto:

    ```bash
    cd mundpay_test
    ```

3. Instale as dependências do projeto com o Composer:

    ```bash
    composer install
    ```

4. Copie o arquivo `.env.example` para `.env`:

    ```bash
    cp .env.example .env
    ```

5. Gere a chave da aplicação:

    ```bash
    php artisan key:generate
    ```

6. Configure o banco de dados no arquivo `.env`. Exemplo de configuração:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=seu_banco
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```

7. Execute as migrações para criar as tabelas no banco de dados:

    ```bash
    php artisan migrate
    ```

## Configuração

1. Configurar o Laravel Sanctum para autenticação:

    ```bash
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    ```

2. Certifique-se de que a autenticação esteja configurada no arquivo `config/auth.php`:

    ```php
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],
    ```

## Executando a Aplicação

Para rodar o servidor local:

```bash
php artisan serve
