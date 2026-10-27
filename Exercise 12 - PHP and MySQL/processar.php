<?php

require "conexao.php";
require "comum.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulario.php");
    exit;
}

$erros = [];

// Receber os dados
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT) ?: null;
$editando = $id !== null;

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$telefone = trim($_POST["telefone"] ?? "");
$senha = $_POST["senha"] ?? "";
$confirmarSenha = $_POST["confirmar_senha"] ?? "";
$data = trim($_POST["data"] ?? "");
$curso = $_POST["curso"] ?? "";
$turno = $_POST["turno"] ?? "";
$interesses = $_POST["interesses"] ?? [];
$observacoes = trim($_POST["observacoes"] ?? "");

if (!is_array($interesses)) {
    $interesses = [];
}

// Verificar campos obrigatórios
if ($nome == "") {
    $erros[] = "O nome deve ser preenchido.";
}

if ($email == "") {
    $erros[] = "O e-mail deve ser preenchido.";
}

// Na alteração, a senha em branco significa "manter a atual"
if (!$editando && $senha == "") {
    $erros[] = "A senha deve ser preenchida.";
}

if ($data == "") {
    $erros[] = "A data de nascimento deve ser preenchida.";
}

if ($curso == "") {
    $erros[] = "O curso deve ser selecionado.";
}

if ($turno == "") {
    $erros[] = "O turno deve ser selecionado.";
}

if (empty($interesses)) {
    $erros[] = "Selecione pelo menos uma área de interesse.";
}

if ($observacoes == "") {
    $erros[] = "O campo de observações deve ser preenchido.";
}


// Validação: tamanhos máximos (iguais aos da tabela)
if (mb_strlen($nome) > 100) {
    $erros[] = "O nome deve ter no máximo 100 caracteres.";
}

if (mb_strlen($observacoes) > 1000) {
    $erros[] = "As observações devem ter no máximo 1000 caracteres.";
}


// Validação: e-mail
if ($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "O e-mail informado não é válido.";
}

// Validação: e-mail já cadastrado (ignorando o próprio registro na alteração)
if ($email != "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare("SELECT id FROM cadastros WHERE email = ? AND id <> ?");
    $stmt->execute([$email, $id ?? 0]);

    if ($stmt->fetch()) {
        $erros[] = "Este e-mail já está cadastrado.";
    }
}


// Validação: telefone (opcional)
if ($telefone != "" && !preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone)) {
    $erros[] = "O telefone deve estar no formato (47) 99999-9999.";
}


// Validação: senha
if ($senha != "") {
    if (strlen($senha) < 6) {
        $erros[] = "A senha deve ter pelo menos 6 caracteres.";
    }

    if ($senha !== $confirmarSenha) {
        $erros[] = "As senhas não conferem.";
    }
}


// Validação: data
$dataFormatada = false;

if ($data != "") {

    $dataFormatada = DateTime::createFromFormat("d/m/Y", $data);

    if (
        !$dataFormatada ||
        $dataFormatada->format("d/m/Y") !== $data
    ) {
        $erros[] = "A data deve estar no formato dd/mm/aaaa.";
        $dataFormatada = false;

    } elseif ($dataFormatada > new DateTime()) {
        $erros[] = "A data de nascimento não pode estar no futuro.";
    }
}


// Validação: valores precisam ser opções existentes no formulário
if ($curso != "" && !in_array($curso, $CURSOS, true)) {
    $erros[] = "Curso inválido.";
}

if ($turno != "" && !in_array($turno, $TURNOS, true)) {
    $erros[] = "Turno inválido.";
}

if (array_diff($interesses, $INTERESSES)) {
    $erros[] = "Área de interesse inválida.";
}


// Mostrar erros
if (!empty($erros)) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Erros no formulário</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <h1>Erros no formulário</h1>
        <ul class="erros">
            <?php foreach ($erros as $erro): ?>
                <li><?= e($erro) ?></li>
            <?php endforeach; ?>
        </ul>
        <!-- history.back() volta mantendo o que foi digitado -->
        <a href="javascript:history.back()">Voltar ao formulário</a>
    </body>
    </html>
    <?php
    exit;
}


// Gravar no banco
$dados = [
    ":nome" => $nome,
    ":email" => $email,
    ":telefone" => $telefone === "" ? null : $telefone,
    ":data_nascimento" => $dataFormatada->format("Y-m-d"),
    ":curso" => $curso,
    ":turno" => $turno,
    ":interesses" => implode(",", $interesses),
    ":observacoes" => $observacoes,
];

if ($editando) {

    $sql = "UPDATE cadastros SET
                nome = :nome,
                email = :email,
                telefone = :telefone,
                data_nascimento = :data_nascimento,
                curso = :curso,
                turno = :turno,
                interesses = :interesses,
                observacoes = :observacoes";

    // Só troca a senha se uma nova foi digitada
    if ($senha != "") {
        $sql .= ", senha = :senha";
        $dados[":senha"] = password_hash($senha, PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id = :id";
    $dados[":id"] = $id;

    $pdo->prepare($sql)->execute($dados);

    $msg = "alterado";

} else {

    $dados[":senha"] = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO cadastros
                (nome, email, senha, telefone, data_nascimento, curso, turno, interesses, observacoes)
            VALUES
                (:nome, :email, :senha, :telefone, :data_nascimento, :curso, :turno, :interesses, :observacoes)";

    $pdo->prepare($sql)->execute($dados);

    $msg = "inserido";
}

// Redireciona (evita reenviar o formulário ao atualizar a página)
header("Location: listar.php?msg=$msg");
exit;
