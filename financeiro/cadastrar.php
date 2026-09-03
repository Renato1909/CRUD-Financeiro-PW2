<?php
require 'config/conexao.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria_id = $_POST['categoria_id'] !== '' ? $_POST['categoria_id'] : null;
    $valor = str_replace(',', '.', $_POST['valor'] ?? '0');
    $data = $_POST['data_transacao'] ?? '';
    $obs = trim($_POST['observacao'] ?? '');

    if (!in_array($tipo, ['receita','despesa']) || $descricao=='' || !is_numeric($valor) || $valor<=0 || $data=='') {
        $erro = 'Preencha todos os campos corretamente. Valor deve ser maior que zero.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO transacoes (tipo, descricao, categoria_id, valor, data_transacao, observacao) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$tipo, $descricao, $categoria_id, $valor, $data, $obs]);
        header('Location: transacoes.php');
        exit;
    }
}
require 'includes/header.php';
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nome")->fetchAll();
?>
<h2>Nova Transação (Create)</h2>
<?php if($erro) echo "<div class='alert alert-danger'>$erro</div>"; ?>
<form method="POST" class="card card-body bg-white shadow-sm">
  <div class="row">
    <div class="col-md-3 mb-3"><label>Tipo*</label>
      <select name="tipo" class="form-select" required>
        <option value="receita">Receita</option>
        <option value="despesa">Despesa</option>
      </select>
    </div>
    <div class="col-md-9 mb-3"><label>Descrição*</label>
      <input name="descricao" class="form-control" required maxlength="150" placeholder="Ex: Salário, Mercado...">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 mb-3"><label>Categoria</label>
      <select name="categoria_id" class="form-select">
        <option value="">-- Sem categoria --</option>
        <?php foreach($categorias as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?> (<?= $c['tipo'] ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-3"><label>Valor (R$)*</label>
      <input name="valor" type="number" step="0.01" min="0.01" class="form-control" required placeholder="0.00">
    </div>
    <div class="col-md-4 mb-3"><label>Data*</label>
      <input name="data_transacao" type="date" class="form-control" required value="<?= date('Y-m-d') ?>">
    </div>
  </div>
  <div class="mb-3"><label>Observação</label>
    <textarea name="observacao" class="form-control" rows="2"></textarea>
  </div>
  <div>
    <button class="btn btn-success">Salvar</button>
    <a href="transacoes.php" class="btn btn-secondary">Voltar</a>
  </div>
</form>
<?php require 'includes/footer.php'; ?>
