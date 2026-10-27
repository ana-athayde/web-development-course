<?php

$usuario = trim($_POST["usuario"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($usuario == "" || $senha == "") {

    echo "<h1>Erro</h1>";
    echo "<p>Usuário e senha devem ser preenchidos.</p>";
    echo '<a href="login.php">Voltar</a>';

    exit;
}

$arquivo = "autenticacao.txt";

$linhas = file($arquivo, FILE_IGNORE_NEW_LINES);

$autenticado = false;

foreach ($linhas as $linha) {

    $dados = explode(";", $linha);

    $usuarioArquivo = $dados[0];
    $senhaArquivo = $dados[1];

    if ($usuario === $usuarioArquivo && $senha === $senhaArquivo) {
        $autenticado = true;
        break;
    }
}

if ($autenticado) {

    echo "<h1>Login realizado!</h1>";

    echo "<p>Bem-vindo, "
        . htmlspecialchars($usuario)
        . "!</p>";

} else {

    echo "<h1>Login inválido</h1>";

    echo "<p>Usuário ou senha incorretos.</p>";

    echo '<a href="login.php">Tentar novamente</a>';
}

?>