# Projeto Backend de Cadastro de Usuários e Produtos

Este projeto é um backend desenvolvido em Laravel, com suporte para o cadastro, edição e deleção de produtos e usuários. Ele utiliza autenticação com Laravel Sanctum para proteger as rotas.

## Índice

- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Funcionalidades](#funcionalidades)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Executando a Aplicação](#executando-a-aplicação)
- [Rotas Disponíveis](#rotas-disponíveis)
- [Testando com o Postman](#testando-com-o-postman)
- [Executando a Queue](#executando-a-queue)
- [Possíveis Erros e Soluções](#possíveis-erros-e-soluções)

## Tecnologias Utilizadas

- [Laravel 11](https://laravel.com/)
- [MySQL](https://www.mysql.com/)
- [PHP 8.2](https://www.php.net/releases/8.2/en.php)
- [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum) - para autenticação
- [Postman](https://www.postman.com/) - para testes de API
- [Mailtrap](https://mailtrap.io/) - para testes de envio de email em produção

## Funcionalidades

- Cadastro de usuários com autenticação
- Edição e remoção de produtos
- Proteção de rotas com autenticação via Sanctum
- Validação de dados ao cadastrar e editar
- Senhas criptografadas no banco de dados com Hash
- Envio de email ao cadastrar ou editar produtos

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
    cd api_laravel_test
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

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=seu_banco
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```

7. Configure o Mailtrap no arquivo `.env`:

    ```plaintext
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=seu_usuario_mailtrap
    MAIL_PASSWORD=sua_senha_mailtrap
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

    - **Obs:** Lembre-se de rodar a queue para testar o recebimento de emails:

    ```bash
    php artisan queue:work
    ```

## Configuração

1. Configurar o Laravel Sanctum para autenticação:

    ```bash
    php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"
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
## Rotas Disponíveis

Abaixo estão listadas as rotas disponíveis na API, juntamente com seus métodos HTTP e descrições:

### Rotas Públicas

- **Login**
    - **POST** `/`
        - Realiza o login do usuário.

- **Usuários**
    - **GET** `/users`
        - Retorna uma lista de todos os usuários cadastrados.
    - **POST** `/users`
        - Cadastra um novo usuário.

- **Produtos**
    - **GET** `/products`
        - Retorna uma lista de todos os produtos disponíveis.

### Rotas Restritas (Requer Autenticação)

#### Usuários
- **PUT** `/users/{user}`
    - Atualiza os dados do usuário especificado.

- **POST** `/logout/{user}`
    - Realiza o logout do usuário especificado.

- **DELETE** `/users/{user}`
    - Remove o usuário especificado.

#### Produtos
- **POST** `/products`
    - Cadastra um novo produto.

- **PUT** `/products/{product}`
    - Atualiza os dados do produto especificado.

- **DELETE** `/products/{product}`
    - Remove o produto especificado.

## Testando com o Postman

Para facilitar os testes da API, um arquivo de coleção do Postman foi exportado e está disponível para download. Esse arquivo contém todas as rotas da API com exemplos de requisições e configurações.

### Baixar a Coleção

- [Clique aqui para baixar a coleção do Postman](caminho/para/seu/arquivo/Postman_Collection.json)

### Como Usar a Coleção no Postman

1. **Importar a Coleção:**
    - Abra o Postman.
    - Clique no botão "Importar" no canto superior esquerdo.
    - Selecione o arquivo `Postman_Collection.json` que você baixou.
    - Clique em "Importar" para adicionar a coleção ao Postman.

2. **Configurar a URL Base:**
    - Verifique se a URL base da API está correta nas configurações da coleção.
    - A URL base deve ser `http://localhost:8000/api`, caso esteja rodando a API localmente.

3. **Executar as Requisições:**
    - Na coleção importada, você encontrará todas as rotas disponíveis.
    - Clique na requisição que deseja testar.
    - Ajuste os parâmetros e o corpo da requisição conforme necessário.
    - Clique em "Enviar" para executar a requisição e visualizar a resposta.

4. **Verificar as Respostas:**
    - Após enviar uma requisição, verifique a aba de "Resposta" para ver os dados retornados pela API.
    - Você pode verificar o código de status HTTP, o corpo da resposta e os headers.

### Exemplos de Requisições

A coleção inclui exemplos para as seguintes operações:

- **Login**
- **Cadastro de Usuários**
- **Edição de Produtos**
- **Visualização de Produtos**
*<p>fique a vontade para modificar</p>*



## Executando a Aplicação

Para rodar o servidor local:

```bash
php artisan serve
