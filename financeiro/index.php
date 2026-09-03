<?php
require 'config/conexao.php';
require 'includes/header.php';

// Totais
$totalReceitas = $pdo->query("SELECT IFNULL(SUM(valor),0) FROM transacoes WHERE tipo='receita'")->fetchColumn();
$totalDespesas = $pdo->query("SELECT IFNULL(SUM(valor),0) FROM transacoes WHERE tipo='despesa'")->fetchColumn();
$saldo = $totalReceitas - $totalDespesas;

// Últimas 10
$stmt = $pdo->query("SELECT t.*, c.nome AS categoria FROM transacoes t LEFT JOIN categorias c ON c.id = t.categoria_id ORDER BY t.data_transacao DESC, t.id DESC LIMIT 10");
$ultimas = $stmt->fetchAll();

// Dados p/ gráfico mensal (últimos 6 meses)
$graf = $pdo->query("
  SELECT DATE_FORMAT(data_transacao,'%m/%Y') AS mes,
         SUM(CASE WHEN tipo='receita' THEN valor ELSE 0 END) AS receitas,
         SUM(CASE WHEN tipo='despesa' THEN valor ELSE 0 END) AS despesas
  FROM transacoes GROUP BY mes ORDER BY MIN(data_transacao) DESC LIMIT 6
")->fetchAll();
$graf = array_reverse($graf);
$labels = json_encode(array_column($graf, 'mes'));
$dRec = json_encode(array_map('floatval', array_column($graf, 'receitas')));
$dDes = json_encode(array_map('floatval', array_column($graf, 'despesas')));

function brl($v){ return 'R$ ' . number_format($v, 2, ',', '.'); }
?>

<h2 class="mb-3">Dashboard — Saldo Geral</h2>

<?php if($saldo < 0): ?>
<div class="alert alert-danger">Atenção: seu saldo está <b>negativo</b> (<?= brl($saldo) ?>). Reveja suas despesas.</div>
<?php else: ?>
<div class="alert alert-success">Saldo positivo de <b><?= brl($saldo) ?></b>. Continue assim!</div>
<?php endif; ?>

<div class="row mb-4">
  <div class="col-md-4"><div class="card card-receita shadow-sm"><div class="card-body">
    <h6>Receitas</h6><h3 class="text-primary"><?= brl($totalReceitas) ?></h3>
    <a href="transacoes.php?tipo=receita" class="btn btn-sm btn-outline-primary">Ver receitas</a>
  </div></div></div>
  <div class="col-md-4"><div class="card card-despesa shadow-sm"><div class="card-body">
    <h6>Despesas</h6><h3 class="text-danger"><?= brl($totalDespesas) ?></h3>
    <a href="transacoes.php?tipo=despesa" class="btn btn-sm btn-outline-danger">Ver despesas</a>
  </div></div></div>
  <div class="col-md-4"><div class="card card-saldo shadow-sm"><div class="card-body">
    <h6>Saldo</h6><h3 class="<?= $saldo>=0?'text-success':'text-danger' ?>"><?= brl($saldo) ?></h3>
    <a href="cadastrar.php" class="btn btn-sm btn-success">+ Nova Transação</a>
  </div></div></div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card shadow-sm mb-4"><div class="card-body">
      <h5>Receitas x Despesas por Mês</h5>
      <canvas id="grafico"></canvas>
    </div></div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm mb-4"><div class="card-body">
      <h5>Últimas Transações</h5>
      <table class="table table-sm table-striped">
        <tr><th>Data</th><th>Descrição</th><th>Tipo</th><th class="text-end">Valor</th></tr>
        <?php foreach($ultimas as $t): ?>
        <tr>
          <td><?= date('d/m/Y', strtotime($t['data_transacao'])) ?></td>
          <td><?= htmlspecialchars($t['descricao']) ?><br><small class="text-muted"><?= htmlspecialchars($t['categoria'] ?? '-') ?></small></td>
          <td><span class="badge <?= $t['tipo']=='receita'?'bg-success':'bg-danger' ?>"><?= $t['tipo'] ?></span></td>
          <td class="text-end"><?= brl($t['valor']) ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <a href="transacoes.php" class="btn btn-sm btn-secondary">Ver todas (CRUD completo)</a>
    </div></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafico');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= $labels ?>,
    datasets: [
      { label: 'Receitas', data: <?= $dRec ?> },
      { label: 'Despesas', data: <?= $dDes ?> }
    ]
  }
});
</script>

<?php require 'includes/footer.php'; ?>
