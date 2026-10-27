<?php

// Ajuste a senha do root definida no mysql_secure_installation
$host = "127.0.0.1";   // 127.0.0.1 força TCP (evita problema de socket no macOS)
$banco = "exercicio12";
$usuarioBanco = "root";
$senhaBanco = "Folhamolhada0305#";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuarioBanco,
        $senhaBanco,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    echo "<h1>Erro ao conectar ao banco de dados</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
