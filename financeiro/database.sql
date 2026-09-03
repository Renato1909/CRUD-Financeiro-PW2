-- =============================================
-- Projeto: Controle Financeiro Pessoal
-- Aluno: Renato Aparecido da Silva | RM: 26478 | GRUPO B
-- Banco: controle_financeiro
-- =============================================

CREATE DATABASE IF NOT EXISTS controle_financeiro
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE controle_financeiro;

-- Tabela de categorias
CREATE TABLE IF NOT EXISTS categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  tipo ENUM('receita','despesa','ambos') NOT NULL DEFAULT 'ambos',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela de transações (receitas e despesas)
CREATE TABLE IF NOT EXISTS transacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tipo ENUM('receita','despesa') NOT NULL,
  descricao VARCHAR(150) NOT NULL,
  categoria_id INT NULL,
  valor DECIMAL(10,2) NOT NULL CHECK (valor > 0),
  data_transacao DATE NOT NULL,
  observacao TEXT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_trans_categoria FOREIGN KEY (categoria_id)
    REFERENCES categorias(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Categorias padrão
INSERT INTO categorias (nome, tipo) VALUES
('Salário', 'receita'),
('Freelance', 'receita'),
('Vendas', 'receita'),
('Outros Ganhos', 'receita'),
('Alimentação', 'despesa'),
('Transporte', 'despesa'),
('Moradia', 'despesa'),
('Saúde', 'despesa'),
('Educação', 'despesa'),
('Lazer', 'despesa'),
('Contas Fixas', 'despesa'),
('Outros Gastos', 'despesa');

-- Dados de exemplo
INSERT INTO transacoes (tipo, descricao, categoria_id, valor, data_transacao, observacao) VALUES
('receita', 'Salário Mensal', 1, 2500.00, CURDATE(), 'Pagamento mensal'),
('receita', 'Freelance Site', 2, 600.00, CURDATE(), 'Projeto extra'),
('despesa', 'Mercado', 5, 350.50, CURDATE(), 'Compras do mês'),
('despesa', 'Ônibus / Uber', 6, 120.00, CURDATE(), ''),
('despesa', 'Aluguel', 7, 800.00, CURDATE(), '');
