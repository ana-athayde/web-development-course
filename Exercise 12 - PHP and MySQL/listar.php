<?php

// php -S localhost:8000

require "conexao.php";
require "comum.php";

$cadastros = $pdo->query("SELECT * FROM cadastros ORDER BY nome")->fetchAll();

$mensagens = [
    "inserido" => "Cadastro realizado com sucesso!",
    "alterado" => "Cadastro alterado com sucesso!",
    "excluido" => "Cadastro excluído com sucesso!",
    "naoencontrado" => "Cadastro não encontrado.",
];

$msg = $mensagens[$_GET["msg"] ?? ""] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastros efetuados</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="validacao.js" defer></script>
</head>

<body>

<nav>
    <a href="formulario.php">Novo cadastro</a>
    <a href="listar.php">Cadastros efetuados</a>
</nav>

<h1>Cadastros efetuados</h1>

<?php if ($msg): ?>
    <p class="mensagem"><?= e($msg) ?></p>
<?php endif; ?>

<?php if (empty($cadastros)): ?>

    <p>Nenhum cadastro encontrado. <a href="formulario.php">Cadastrar o primeiro</a>.</p>

<?php else: ?>

    <div class="tabela">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Nascimento</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Interesses</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cadastros as $c): ?>
                <tr>
                    <td><?= e($c["nome"]) ?></td>
                    <td><?= e($c["email"]) ?></td>
                    <td><?= e($c["telefone"] ?? "—") ?></td>
                    <td><?= e(date("d/m/Y", strtotime($c["data_nascimento"]))) ?></td>
                    <td><?= e($c["curso"]) ?></td>
                    <td><?= e($c["turno"]) ?></td>
                    <td><?= e(str_replace(",", ", ", $c["interesses"])) ?></td>
                    <td><?= nl2br(e($c["observacoes"])) ?></td>
                    <td class="acoes">
                        <a href="formulario.php?id=<?= e($c["id"]) ?>">Alterar</a>

                        <!-- Exclusão por POST (link GET poderia ser disparado sem querer) -->
                        <form action="excluir.php" method="post" class="form-excluir"
                              data-nome="<?= e($c["nome"]) ?>">
                            <input type="hidden" name="id" value="<?= e($c["id"]) ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <p><?= count($cadastros) ?> cadastro(s).</p>

<?php endif; ?>

</body>
</html>
