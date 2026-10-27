<!-- php -S localhost:8000 -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

<h1>Login</h1>

<form action="autenticar.php" method="post">

    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario">

    <br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha">

    <br><br>

    <input type="submit" value="Entrar">
    <input type="reset" value="Limpar">

</form>

</body>
</html>