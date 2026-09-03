<?php
require 'config/conexao.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM transacoes WHERE id=?");
$stmt->execute([$id]);
$t = $stmt->fetch();
if (!$t) die("Transação não encontrada. <a href='transacoes.php'>Voltar</a>");

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria_id = $_POST['categoria_id'] !== '' ? $_POST['categoria_id'] : null;
    $valor = str_replace(',', '.', $_POST['valor'] ?? '0');
    $data = $_POST['data_transacao'] ?? '';
    $obs = trim($_POST['observacao'] ?? '');
    if (!in_array($tipo, ['receita','despesa']) || $descricao=='' || !is_numeric($valor) || $valor<=0 || $data=='') {
        $erro = 'Preencha todos os campos corretamente.';
    } else {
        $up = $pdo->prepare("UPDATE transacoes SET tipo=?, descricao=?, categoria_id=?, valor=?, data_transacao=?, observacao=? WHERE id=?");
        $up->execute([$tipo, $descricao, $categoria_id, $valor, $data, $obs, $id]);
        header('Location: transacoes.php');
        exit;
    }
}
require 'includes/header.php';
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nome")->fetchAll();
?>
<h2>Editar Transação #<?= $t['id'] ?> (Update)</h2>
<?php if($erro) echo "<div class='alert alert-danger'>$erro</div>"; ?>
<form method="POST" class="card card-body bg-white shadow-sm">
  <div class="row">
    <div class="col-md-3 mb-3"><label>Tipo*</label>
      <select name="tipo" class="form-select">
        <option value="receita" <?= $t['tipo']=='receita'?'selected':'' ?>>Receita</option>
        <option value="despesa" <?= $t['tipo']=='despesa'?'selected':'' ?>>Despesa</option>
      </select>
    </div>
    <div class="col-md-9 mb-3"><label>Descrição*</label>
      <input name="descricao" class="form-control" required value="<?= htmlspecialchars($t['descricao']) ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 mb-3"><label>Categoria</label>
      <select name="categoria_id" class="form-select">
        <option value="">-- Sem categoria --</option>
        <?php foreach($categorias as $c): ?>
        <option value="<?= $c['id'] ?>" <?= $t['categoria_id']==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['nome']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-3"><label>Valor*</label>
      <input name="valor" type="number" step="0.01" min="0.01" class="form-control" required value="<?= $t['valor'] ?>">
    </div>
    <div class="col-md-4 mb-3"><label>Data*</label>
      <input name="data_transacao" type="date" class="form-control" required value="<?= $t['data_transacao'] ?>">
    </div>
  </div>
  <div class="mb-3"><label>Observação</label>
    <textarea name="observacao" class="form-control"><?= htmlspecialchars($t['observacao']) ?></textarea>
  </div>
  <button class="btn btn-warning">Atualizar</button>
  <a href="transacoes.php" class="btn btn-secondary">Voltar</a>
</form>
<?php require 'includes/footer.php'; ?>
