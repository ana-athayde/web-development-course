<?php

// Opções válidas dos campos (usadas no formulário e na validação)
$CURSOS = [
    "Ciência da Computação",
    "Engenharia de Software",
    "Sistemas de Informação",
];

$TURNOS = ["Manhã", "Tarde", "Noite"];

$INTERESSES = ["Programação", "Redes", "Segurança"];

// Atalho para escapar saída HTML
function e($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, "UTF-8");
}
