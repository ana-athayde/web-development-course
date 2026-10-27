<!-- Tem que rodar: php -S localhost:8000 e entrar no: http://localhost:8000/4.php -->

<?php

session_start();

if (isset($_POST["nome"])) {
    $_SESSION["nome"] = $_POST["nome"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exemplo de Session</title>
</head>
<body>

<?php

if (isset($_SESSION["nome"])) {

    echo "Olá, " . $_SESSION["nome"] . "!";

} else {

?>

    <form method="post">
        <label>Digite seu nome:</label>
        <input type="text" name="nome" required>
        <button type="submit">Enviar</button>
    </form>

<?php

}

?>

</body>
</html>