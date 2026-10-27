<?php

require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: listar.php?msg=naoencontrado");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM cadastros WHERE id = ?");
$stmt->execute([$id]);

$msg = $stmt->rowCount() > 0 ? "excluido" : "naoencontrado";

header("Location: listar.php?msg=$msg");
exit;
