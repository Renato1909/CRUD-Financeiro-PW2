# CRUD Financeiro PW2

Sistema web de controle financeiro pessoal desenvolvido em PHP e MySQL. Implementa CRUD de receitas e despesas, categorias, filtros de consulta e dashboard com saldo e gráfico mensal.

## Funcionalidades

- Dashboard com receitas, despesas, saldo e últimas transações.
- CRUD completo de transações: criar, consultar, editar e excluir.
- Filtros por tipo e categoria.
- Busca por descrição.
- Gerenciamento de categorias.
- Gráfico mensal de receitas e despesas.
- Validação de campos e valores.
- Persistência em MySQL usando PDO e prepared statements.

## Tecnologias

- PHP 8+
- PDO
- MySQL/MariaDB
- HTML5 e CSS3
- Bootstrap 5.3.3
- Chart.js
- XAMPP e phpMyAdmin

## Estrutura

```
CRUD-Financeiro-PW2/
├── README.md
└── financeiro/
    ├── index.php
    ├── transacoes.php
    ├── cadastrar.php
    ├── editar.php
    ├── excluir.php
    ├── categorias.php
    ├── database.sql
    ├── config/
    │   └── conexao.php
    ├── includes/
    │   ├── header.php
    │   └── footer.php
    └── assets/
        └── css/
            └── style.css
```

## Banco de dados

O banco utilizado é `controle_financeiro`.

### categorias

- `id`: chave primária.
- `nome`: nome da categoria.
- `tipo`: receita, despesa ou ambos.
- `criado_em`: data/hora de criação.

### transacoes

- `id`: chave primária.
- `tipo`: receita ou despesa.
- `descricao`: descrição da movimentação.
- `categoria_id`: chave estrangeira para categorias.
- `valor`: valor positivo da movimentação.
- `data_transacao`: data da movimentação.
- `observacao`: informação opcional.
- `criado_em`: data/hora de criação.

A relação entre categorias e transações é 1:N. A chave estrangeira utiliza `ON DELETE SET NULL` e `ON UPDATE CASCADE`.

O arquivo `financeiro/database.sql` cria o banco, tabelas, categorias padrão e dados de exemplo.

## Configuração local

O projeto foi preparado para XAMPP com:

```
Host: localhost
Banco: controle_financeiro
Usuário: root
Senha: vazia
Charset: utf8mb4
```

A conexão está em `financeiro/config/conexao.php`.

> A configuração com usuário root sem senha é destinada ao ambiente local de desenvolvimento e não deve ser usada como configuração de produção.

## Como executar

1. Instale o XAMPP.
2. Inicie Apache e MySQL pelo XAMPP Control Panel.
3. Clone o repositório:

```bash
git clone https://github.com/Renato1909/CRUD-Financeiro-PW2.git
```

4. Coloque o projeto em `C:\\xampp\\htdocs\\`.
5. Abra `http://localhost/phpmyadmin`.
6. Importe `financeiro/database.sql`.
7. Acesse:

```
http://localhost/CRUD-Financeiro-PW2/financeiro/
```

## Arquitetura simplificada

```
Usuário
  ↓
PHP / HTML / Bootstrap
  ↓
Formulários e consultas
  ↓
PDO + Prepared Statements
  ↓
MySQL
  ↓
Resultados no dashboard e nas tabelas
```

A aplicação usa componentes compartilhados em `includes/header.php` e `includes/footer.php`. A conexão com o banco é centralizada em `config/conexao.php`.

## Segurança e boas práticas presentes

- PDO com tratamento de exceções.
- Prepared statements para operações parametrizadas.
- `PDO::ERRMODE_EXCEPTION`.
- `PDO::FETCH_ASSOC`.
- Emulação de prepared statements desativada.
- Validação de tipo, descrição, data e valor.
- `htmlspecialchars()` na saída de conteúdo textual.

## Teste manual

Para validar o funcionamento:

1. abra o dashboard;
2. cadastre uma receita;
3. cadastre uma despesa;
4. consulte as transações;
5. filtre por tipo;
6. filtre por categoria;
7. pesquise por descrição;
8. edite uma transação;
9. exclua uma transação;
10. confira o saldo atualizado;
11. crie e exclua uma categoria;
12. confirme os dados no phpMyAdmin.

## Objetivos acadêmicos

O projeto demonstra conceitos de:

- desenvolvimento web com PHP;
- SQL e banco de dados relacional;
- chaves primárias e estrangeiras;
- relacionamentos 1:N;
- operações CRUD;
- formulários HTML;
- validação de dados;
- prepared statements;
- organização básica de aplicações web;
- integração entre frontend, backend e banco de dados.

## Escopo

Este é um projeto acadêmico e educacional. O sistema não possui autenticação de usuários, autorização por perfil, proteção CSRF ou API dedicada. Portanto, o escopo atual é adequado para estudo e execução local, não para uso financeiro em produção.

## Autor

**Renato Aparecido da Silva**

Projeto acadêmico de Desenvolvimento de Sistemas / PW2.

## Licença

Nenhuma licença open source específica foi definida no repositório até o momento.
