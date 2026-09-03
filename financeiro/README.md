# 💰 Controle Financeiro Pessoal

**Aluno:** Renato Aparecido da Silva — **RM:** 26478 — **Grupo B**
**Curso:** NOVOTEC / Desenvolvimento de Sistemas — Turma A — 2025 — 2º Módulo
**Projeto:** Registro de receitas e despesas com categorias, valores, datas e dashboard básico de saldo.

## 📌 Descrição
Sistema web em PHP + MySQL com CRUD completo:
- Cadastrar, Listar, Editar e Excluir receitas e despesas
- Categorias (ex: Salário, Alimentação, Transporte...)
- Filtros por tipo, categoria e busca por descrição
- Dashboard com total de receitas, despesas, saldo e gráfico mensal
- Validação de valor > 0 e campos obrigatórios

## 🛠️ Tecnologias
- PHP 8 + PDO
- MySQL / MariaDB
- HTML5, CSS3, Bootstrap 5, Chart.js
- XAMPP (Apache + phpMyAdmin)

## 📁 Estrutura
```
/
├── index.php          → Dashboard (saldo, totais, gráfico, últimas)
├── transacoes.php     → Listar / Filtrar (Read)
├── cadastrar.php      → Criar transação (Create)
├── editar.php         → Editar transação (Update)
├── excluir.php        → Excluir transação (Delete)
├── categorias.php     → CRUD de categorias
├── config/conexao.php → Conexão PDO
├── includes/header.php, footer.php
├── assets/css/style.css
└── database.sql       → Script do banco
```

## 🗄️ Banco de Dados
Banco `controle_financeiro` com 2 tabelas:
- `categorias(id, nome, tipo, criado_em)`
- `transacoes(id, tipo, descricao, categoria_id, valor, data_transacao, observacao, criado_em)`

## ▶️ Como rodar (XAMPP)
1. Instale o XAMPP e inicie Apache + MySQL
2. Copie esta pasta para `C:\xampp\htdocs\financeiro`
3. Abra `http://localhost/phpmyadmin` → Importar → selecione `database.sql` → Executar
4. Verifique `config/conexao.php` (usuário `root`, senha vazia por padrão)
5. Acesse `http://localhost/financeiro/`

## 🎥 Roteiro do vídeo tutorial (CRUD)
Grave a tela mostrando nesta ordem (2 a 4 min):
1. Dashboard inicial com saldo (index.php)
2. Clique em "Nova Transação" → cadastre uma RECEITA (Create)
3. Cadastre uma DESPESA
4. Vá em Transações → use o filtro por tipo e busca (Read)
5. Clique em Editar em um item e altere o valor (Update)
6. Clique em Excluir em um item (Delete)
7. Mostre Dashboard atualizado + Categorias
8. Mostre o phpMyAdmin com as tabelas

## 🔗 Entrega
- [ ] Subir este código no GitHub (repositório público `controle-financeiro-renato`)
- [ ] Entregar link do GitHub + este README
- [ ] Entregar `database.sql`
- [ ] Entregar link do vídeo (YouTube não listado) mostrando navegação + CRUD
