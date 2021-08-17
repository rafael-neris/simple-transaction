# Simple Transaction

## Descrição

API REST desenvolvida com Laravel 6.x.

Projeto dedicado a demonstração de transação de valores entre usuários, simulando uma carteira virtual. Contém apenas uma rota que realiza a transferência entre usuários.

> A aplicação já possui as máquinas necessárias para execução baseadas no arquivo `docker-compose.yml`.

## Instalação/Configuração (Docker)

- Faça o clone do projeto;
- Execute o comando `docker-compose up -d` para criar as máquinas necessárias;
    - Para validar se tudo ocorreu bem, execute `docker-compose ps` e verifique se as 3 máquinas necessárias foram criadas _(app, db, nginx)_.
- Execute o composer dentro da máquina _app_ para instalar as dependências do projeto com o comando `docker-compose exec -T app composer install`;
- Verifique se o arquivo _.env_ foi criado após execução do composer.
    - Caso o arquivo não tenha sido criado:
        - Crie um arquivo _.env_ na raiz do projeto com base no arquivo _.env.example_ e
        - Execute o comando `docker-compose exec app php artisan key:generate` para gerar key da aplicação.
- Altere o arquivo _.env_ com as configurações:
```env
...

DB_HOST=db
DB_DATABASE=simple-transaction
DB_USERNAME=root
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PASSWORD=simple-transaction
...
```
- Execute as migrations junto com os seeaders para iniciar o banco de dados `docker-compose exec app php artisan migrate --seed`;
- A aplicação roda em `localhost:8000`

## Realizando uma transação (transferência entre usuários)

A base inicial contém 3 usuários cadastrados com saldo em carteira sendo:

```json
[
    {
        "id": 1,
        "name": "Pessoa Física 01",
        "email": "pf1@email.com",
        "user_type_id": 1,
        "wallet": {
            "id": 1,
            "balance": 50000
        }
    },
    {
        "id": 2,
        "name": "Pessoa Física 02",
        "email": "pf2@email.com",
        "user_type_id": 1,
        "wallet": {
            "id": 2,
            "balance": 25000
        }
    },
    {
        "id": 3,
        "name": "Pessoa Jurídica 01",
        "email": "pj1@email.com",
        "user_type_id": 2,
        "wallet": {
            "id": 3,
            "balance": 25000
        }
    }
]
```

### Payload

POST    `/api/transaction`

```json
{
    "payer": 1, // (int) id do usuário pagador
    "payee": 2, // (int) id do usuário tomador
    "value": 10000 // (int) valor da transferência em centavos
}
```

_Atenção ao valor da transferência em centavos, sendo sempre um número inteiro._

## Considerações

- A notificação de recebimento de uma transferência é incluída em uma fila de envio. Para deixar processando seu envio utilize o comando `docker-compose exec app php artisan queue:work`;

## Melhorias

- Tratar notificações com falha e recolocar na fila de envio;
- Refinar tratamento de exceptions;
- Melhorar implementação de tests;
