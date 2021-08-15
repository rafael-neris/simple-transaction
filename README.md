# Simple Transaction

## Descrição

API REST desenvolvida com Laravel 6.x.

Projeto dedicado a demonstração de transação de valores entre usuários, simulando uma carteira virtual

> A aplicação já possui as máquinas necessárias para execução baseadas no arquivo `docker-compose.yml`.

## Instalação/Configuração (Docker)

- Faça o clone do projeto;
- Execute o comando `docker-compose up -d` para criar as máquinas necessárias;
    - Para validar se tudo ocorreu bem, execute `docker-compose ps` e verifique se as 3 máquinas necessárias foram criadas _(app, db, nginx)_.
- Execute o composer dentro da máquina _app_ para instalar as dependências do projeto com o comando `docker-compose exec -T app composer install`;
- Verifique se o arquivo _.env_ foi criado após execução do composer. Caso não tenha sido, crie um arquivo _.env_ na raiz do projeto com base no arquivo _.env.example_.
- Altere o arquivo _.env_ com as configurações de banco de dados:
```env
...

DB_HOST=db
DB_DATABASE=simple-transaction
DB_USERNAME=root
DB_PASSWORD=secret

...
```

## Considerações

...