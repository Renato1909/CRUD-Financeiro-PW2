<?php
require 'config/conexao.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM transacoes WHERE id=?");
$stmt->execute([$id]);
header('Location: transacoes.php');
exit;
