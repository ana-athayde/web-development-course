<?php

$arquivo = "contador.txt";

$visitas = file_get_contents($arquivo);

$visitas++;

file_put_contents($arquivo, $visitas);

echo "Esta página foi visitada $visitas vezes.";

?>