<?php

// php -S localhost:8000

require "conexao.php";
require "comum.php";

// Valores padrão (cadastro novo)
$cadastro = [
    "nome" => "",
    "email" => "",
    "telefone" => "",
    "data" => "",
    "curso" => "",
    "turno" => "",
    "interesses" => [],
    "observacoes" => "",
];

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$editando = false;

// Se veio um id, carrega o registro para alteração
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM cadastros WHERE id = ?");
    $stmt->execute([$id]);
    $registro = $stmt->fetch();

    if (!$registro) {
        header("Location: listar.php?msg=naoencontrado");
        exit;
    }

    $editando = true;

    $cadastro = [
        "nome" => $registro["nome"],
        "email" => $registro["email"],
        "telefone" => $registro["telefone"],
        "data" => DateTime::createFromFormat("Y-m-d", $registro["data_nascimento"])->format("d/m/Y"),
        "curso" => $registro["curso"],
        "turno" => $registro["turno"],
        "interesses" => $registro["interesses"] === "" ? [] : explode(",", $registro["interesses"]),
        "observacoes" => $registro["observacoes"],
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $editando ? "Alterar cadastro" : "Formulário de Cadastro" ?></title>
    <link rel="stylesheet" href="estilo.css">
    <script src="validacao.js" defer></script>
</head>

<body>

<nav>
    <a href="formulario.php">Novo cadastro</a>
    <a href="listar.php">Cadastros efetuados</a>
</nav>

<h1><?= $editando ? "Alterar cadastro" : "Cadastro" ?></h1>

<div id="erros-js" class="erros" hidden></div>

<form id="form-cadastro" action="processar.php" method="post"
      data-editando="<?= $editando ? "1" : "0" ?>">

    <?php if ($editando): ?>
        <input type="hidden" name="id" value="<?= e($id) ?>">
    <?php endif; ?>

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required maxlength="100"
           value="<?= e($cadastro["nome"]) ?>">

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required maxlength="150"
           value="<?= e($cadastro["email"]) ?>">

    <label for="telefone">Telefone (opcional):</label>
    <input type="tel" id="telefone" name="telefone" placeholder="(47) 99999-9999"
           pattern="\(?\d{2}\)?\s?\d{4,5}-?\d{4}"
           title="Formato: (47) 99999-9999"
           value="<?= e($cadastro["telefone"]) ?>">

    <label for="senha">Senha<?= $editando ? " (deixe em branco para manter a atual)" : "" ?>:</label>
    <input type="password" id="senha" name="senha" minlength="6"
           <?= $editando ? "" : "required" ?>>

    <label for="confirmar_senha">Confirmar senha:</label>
    <input type="password" id="confirmar_senha" name="confirmar_senha" minlength="6"
           <?= $editando ? "" : "required" ?>>

    <label for="data">Data de nascimento:</label>
    <input type="text" id="data" name="data" placeholder="dd/mm/aaaa" required
           pattern="\d{2}/\d{2}/\d{4}" title="Use o formato dd/mm/aaaa"
           value="<?= e($cadastro["data"]) ?>">

    <label for="curso">Curso:</label>
    <select id="curso" name="curso" required>
        <option value="">Selecione</option>
        <?php foreach ($CURSOS as $curso): ?>
            <option value="<?= e($curso) ?>" <?= $cadastro["curso"] === $curso ? "selected" : "" ?>>
                <?= e($curso) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <fieldset>
        <legend>Turno:</legend>
        <?php foreach ($TURNOS as $i => $turno): ?>
            <input type="radio" id="turno<?= $i ?>" name="turno" value="<?= e($turno) ?>"
                   <?= $i === 0 ? "required" : "" ?>
                   <?= $cadastro["turno"] === $turno ? "checked" : "" ?>>
            <label for="turno<?= $i ?>" class="inline"><?= e($turno) ?></label>
        <?php endforeach; ?>
    </fieldset>

    <fieldset>
        <legend>Áreas de interesse:</legend>
        <?php foreach ($INTERESSES as $i => $interesse): ?>
            <input type="checkbox" id="interesse<?= $i ?>" name="interesses[]" value="<?= e($interesse) ?>"
                   <?= in_array($interesse, $cadastro["interesses"], true) ? "checked" : "" ?>>
            <label for="interesse<?= $i ?>" class="inline"><?= e($interesse) ?></label>
        <?php endforeach; ?>
    </fieldset>

    <label for="observacoes">Observações:</label>
    <textarea id="observacoes" name="observacoes" rows="5" cols="40" required
              maxlength="1000"><?= e($cadastro["observacoes"]) ?></textarea>

    <div class="botoes">
        <input type="submit" value="<?= $editando ? "Salvar alterações" : "Cadastrar" ?>">
        <input type="reset" value="Limpar">
    </div>

</form>

</body>
</html>
