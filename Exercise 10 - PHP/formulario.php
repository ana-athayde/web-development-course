<!-- php -S localhost:8000 -->


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Cadastro</title>
</head>

<body>

<h1>Cadastro</h1>

<form action="processar.php" method="post">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome">
    <br><br>

    <label for="email">E-mail:</label>
    <input type="text" id="email" name="email">
    <br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha">
    <br><br>

    <label for="data">Data de nascimento:</label>
    <input type="text" id="data" name="data" placeholder="dd/mm/aaaa">
    <br><br>

    <label for="curso">Curso:</label>
    <select id="curso" name="curso">
        <option value="">Selecione</option>
        <option value="Ciência da Computação">Ciência da Computação</option>
        <option value="Engenharia de Software">Engenharia de Software</option>
        <option value="Sistemas de Informação">Sistemas de Informação</option>
    </select>
    <br><br>

    <p>Turno:</p>

    <input type="radio" id="manha" name="turno" value="Manhã">
    <label for="manha">Manhã</label>

    <input type="radio" id="tarde" name="turno" value="Tarde">
    <label for="tarde">Tarde</label>

    <input type="radio" id="noite" name="turno" value="Noite">
    <label for="noite">Noite</label>

    <br><br>

    <p>Áreas de interesse:</p>

    <input type="checkbox" id="programacao" name="interesses[]" value="Programação">
    <label for="programacao">Programação</label>

    <input type="checkbox" id="redes" name="interesses[]" value="Redes">
    <label for="redes">Redes</label>

    <input type="checkbox" id="seguranca" name="interesses[]" value="Segurança">
    <label for="seguranca">Segurança</label>

    <br><br>

    <label for="observacoes">Observações:</label>
    <br>
    <textarea id="observacoes" name="observacoes" rows="5" cols="40"></textarea>

    <br><br>

    <input type="submit" value="Cadastrar">
    <input type="reset" value="Limpar">

</form>

</body>
</html>