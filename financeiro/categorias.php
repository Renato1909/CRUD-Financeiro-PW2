<?php
require 'config/conexao.php';

// Criar categoria
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['nova_categoria'])) {
    $nome = trim($_POST['nome'] ?? '');
    $tipo = $_POST['tipo'] ?? 'ambos';
    if ($nome !== '' && in_array($tipo, ['receita','despesa','ambos'])) {
        $pdo->prepare("INSERT INTO categorias (nome,tipo) VALUES (?,?)")->execute([$nome,$tipo]);
        header('Location: categorias.php'); exit;
    }
}
// Excluir categoria
if (isset($_GET['del'])) {
    $pdo->prepare("DELETE FROM categorias WHERE id=?")->execute([$_GET['del']]);
    header('Location: categorias.php'); exit;
}
require 'includes/header.php';
$lista = $pdo->query("SELECT * FROM categorias ORDER BY nome")->fetchAll();
?>
<h2>Categorias</h2>
<form method="POST" class="card card-body mb-3 bg-white">
  <div class="row">
    <div class="col-md-6"><input name="nome" class="form-control" placeholder="Nome da categoria (Ex: Pix, iFood...)" required></div>
    <div class="col-md-4">
      <select name="tipo" class="form-select">
        <option value="ambos">Ambos</option>
        <option value="receita">Receita</option>
        <option value="despesa">Despesa</option>
      </select>
    </div>
    <div class="col-md-2"><button name="nova_categoria" class="btn btn-success w-100">Adicionar</button></div>
  </div>
</form>
<table class="table table-bordered bg-white">
<tr><th>ID</th><th>Nome</th><th>Tipo</th><th>Ação</th></tr>
<?php foreach($lista as $c): ?>
<tr><td><?= $c['id'] ?></td><td><?= htmlspecialchars($c['nome']) ?></td><td><?= $c['tipo'] ?></td>
<td><a href="?del=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a></td></tr>
<?php endforeach; ?>
</table>
<a href="index.php" class="btn btn-secondary">Voltar</a>
<?php require 'includes/footer.php'; ?>
