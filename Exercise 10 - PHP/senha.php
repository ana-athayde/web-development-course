<?php

$senha = "minhaSenha123";

$hash = password_hash($senha, PASSWORD_DEFAULT);

echo "<h1>Exemplo de Hash de Senha</h1>";

echo "<p><strong>Senha original:</strong> "
    . htmlspecialchars($senha)
    . "</p>";

echo "<p><strong>Hash:</strong> "
    . htmlspecialchars($hash)
    . "</p>";

if (password_verify($senha, $hash)) {

    echo "<p>A senha foi validada corretamente!</p>";

} else {

    echo "<p>A senha é inválida.</p>";
}

?>