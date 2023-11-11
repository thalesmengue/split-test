# Teste de Back End

## Descrição
Criar uma API Rest que possua os métodos de um CRUD (create, read, update e delete) com paginação para a leitura dos dados.

## Como rodar o projeto
```bash
# clone o projeto
$ git clone git@github.com:thalesmengue/split-test.git

# instale as dependências
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# crie o arquivo .env
$ cp .env.example .env

# inicie o sail
$ ./vendor/bin/sail up -d

# gerar uma nova chave da aplicação
$ ./vendor/bin/sail artisan key:generate

# migre as tabelas
$ ./vendor/bin/sail artisan migrate

# migre as tabelas do banco de dados de teste
$ ./vendor/bin/sail artisan migrate --database=testing

```

Após rodar os comandos acima, a aplicação estará rodando em http://localhost

## Rotas
| Método HTTP | Endpoint             | Descrição                                                                                                                                      |
|-------------|----------------------|------------------------------------------------------------------------------------------------------------------------------------------------|
| GET         | `/api/produtos`      | Rota usada para listar os produtos, com paginação. (pode ser enviado um parâmetro de query "per_page" para definir dinamicamente a paginação). |
| GET         | `/api/produtos/{id}` | Retorna um único produto.                                                                                                                      |
| POST        | `/api/produtos`      | Rota usada para cadastrar um produto.                                                                                                          |
| PUT         | `/api/produtos/{id}` | Rota usada para atualizar as informações de um produto.                                                                                        |
| DELETE      | `/api/produtos{id}`  | Rota usada para deletar um produto.                                                                                                            |


## Exemplos de requisições
Request esperado para cadastro de um produto
```json
{
    "nome": "Cadeira",
    "descricao": "Produto usado, em boas condições",
    "preco": 32.99,
    "quantidade": 1
}
```

Response esperada do cadastro de um produto
```json
{
    "nome": "Cadeira",
    "descricao": "Produto usado, em boas condições",
    "preco": 32.99,
    "quantidade": 1,
    "id": 1
}
```


## Testes
Foram realizados testes para cobrir os possíveis cenários da aplicação.

Para rodar os testes digite:
```bash
 ./vendor/bin/sail artisan test
```

## Tecnologias utilizadas
- [Laravel 10](https://laravel.com/docs/10.x/installation)
- [PHP 8.2](https://www.php.net/)
- [MySQL 8.0](https://www.mysql.com/)
- [Docker](https://www.docker.com/)
