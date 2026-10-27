<?php

$erros = [];

// Receber os dados
$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";
$data = trim($_POST["data"] ?? "");
$curso = $_POST["curso"] ?? "";
$turno = $_POST["turno"] ?? "";
$interesses = $_POST["interesses"] ?? [];
$observacoes = trim($_POST["observacoes"] ?? "");

// Verificar campos obrigatórios
if ($nome == "") {
    $erros[] = "O nome deve ser preenchido.";
}

if ($email == "") {
    $erros[] = "O e-mail deve ser preenchido.";
}

if ($senha == "") {
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


// Validação 1: e-mail
if ($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "O e-mail informado não é válido.";
}


// Validação 2: data
if ($data != "") {

    $dataFormatada = DateTime::createFromFormat("d/m/Y", $data);

    if (
        !$dataFormatada ||
        $dataFormatada->format("d/m/Y") !== $data
    ) {
        $erros[] = "A data deve estar no formato dd/mm/aaaa.";
    }
}


// Mostrar erros
if (!empty($erros)) {

    echo "<h1>Erros no formulário</h1>";

    echo "<ul>";

    foreach ($erros as $erro) {
        echo "<li>$erro</li>";
    }

    echo "</ul>";

    echo '<a href="formulario.php">Voltar ao formulário</a>';

} else {

    echo "<h1>Cadastro realizado com sucesso!</h1>";

    echo "<h2>Informações cadastradas:</h2>";

    echo "<p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>";

    echo "<p><strong>E-mail:</strong> " . htmlspecialchars($email) . "</p>";

    echo "<p><strong>Data de nascimento:</strong> " . htmlspecialchars($data) . "</p>";

    echo "<p><strong>Curso:</strong> " . htmlspecialchars($curso) . "</p>";

    echo "<p><strong>Turno:</strong> " . htmlspecialchars($turno) . "</p>";

    echo "<p><strong>Áreas de interesse:</strong> "
        . htmlspecialchars(implode(", ", $interesses))
        . "</p>";

    echo "<p><strong>Observações:</strong> "
        . htmlspecialchars($observacoes)
        . "</p>";

    echo '<br>';
    echo '<a href="formulario.php">Voltar</a>';
}

?>