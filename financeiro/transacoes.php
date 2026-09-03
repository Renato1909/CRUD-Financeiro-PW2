<?php
require 'config/conexao.php';
require 'includes/header.php';

$tipo = $_GET['tipo'] ?? '';
$busca = $_GET['busca'] ?? '';
$categoria_id = $_GET['categoria_id'] ?? '';

$sql = "SELECT t.*, c.nome AS categoria FROM transacoes t LEFT JOIN categorias c ON c.id=t.categoria_id WHERE 1=1";
$params = [];
if ($tipo === 'receita' || $tipo === 'despesa') { $sql .= " AND t.tipo = ?"; $params[] = $tipo; }
if ($busca !== '') { $sql .= " AND t.descricao LIKE ?"; $params[] = "%$busca%"; }
if ($categoria_id !== '') { $sql .= " AND t.categoria_id = ?"; $params[] = $categoria_id; }
$sql .= " ORDER BY t.data_transacao DESC, t.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$lista = $stmt->fetchAll();
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nome")->fetchAll();

function brl($v){ return 'R$ ' . number_format($v,2,',','.'); }
?>
<h2>Transações (CRUD)</h2>
<a href="cadastrar.php" class="btn btn-success mb-3">+ Nova</a>
<a href="index.php" class="btn btn-secondary mb-3">Dashboard</a>

<form class="row g-2 mb-3" method="GET">
  <div class="col-md-3">
    <select name="tipo" class="form-select">
      <option value="">Todos os tipos</option>
      <option value="receita" <?= $tipo=='receita'?'selected':'' ?>>Receita</option>
      <option value="despesa" <?= $tipo=='despesa'?'selected':'' ?>>Despesa</option>
    </select>
  </div>
  <div class="col-md-3">
    <select name="categoria_id" class="form-select">
      <option value="">Todas categorias</option>
      <?php foreach($categorias as $c): ?>
      <option value="<?= $c['id'] ?>" <?= $categoria_id==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['nome']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4"><input name="busca" class="form-control" placeholder="Buscar descrição..." value="<?= htmlspecialchars($busca) ?>"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Filtrar</button></div>
</form>

<table class="table table-striped table-bordered bg-white">
<tr><th>ID</th><th>Data</th><th>Descrição</th><th>Categoria</th><th>Tipo</th><th class="text-end">Valor</th><th>Ações</th></tr>
<?php foreach($lista as $t): ?>
<tr>
  <td><?= $t['id'] ?></td>
  <td><?= date('d/m/Y', strtotime($t['data_transacao'])) ?></td>
  <td><?= htmlspecialchars($t['descricao']) ?></td>
  <td><?= htmlspecialchars($t['categoria'] ?? '-') ?></td>
  <td><span class="badge <?= $t['tipo']=='receita'?'bg-success':'bg-danger' ?>"><?= $t['tipo'] ?></span></td>
  <td class="text-end"><?= brl($t['valor']) ?></td>
  <td>
    <a href="editar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
    <a href="excluir.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir esta transação?')">Excluir</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
<?php if(!count($lista)) echo "<div class='alert alert-info'>Nenhuma transação encontrada.</div>"; ?>

<?php require 'includes/footer.php'; ?>
