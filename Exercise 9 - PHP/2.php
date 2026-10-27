<?php

function apresentarProgramador($nome, $linguagens)
{
    $nome = strtoupper($nome);

    $quantidade = count($linguagens);

    $lista = implode(", ", $linguagens);

    return "Olá, meu nome é $nome. Eu estudo $quantidade linguagens: $lista.";
}

$linguagens = ["PHP", "JavaScript", "Python"];

echo apresentarProgramador("Ana", $linguagens);

?>