# Exercício PHP + MySQL — Cadastro (ODAW)

Alunos: Ana e Mauricio

CRUD de cadastro de alunos usando o formulário dos exercícios anteriores.

## Arquivos

| Arquivo          | Função                                                       |
|------------------|--------------------------------------------------------------|
| `banco.sql`      | Cria o banco `exercicio12` e a tabela `cadastros`            |
| `conexao.php`    | Conexão PDO com o MySQL                                      |
| `comum.php`      | Opções válidas (cursos, turnos, interesses) e função `e()`   |
| `formulario.php` | Inserir (sem `id`) ou alterar (`formulario.php?id=N`)        |
| `processar.php`  | Valida no PHP e faz `INSERT` ou `UPDATE`                     |
| `listar.php`     | Mostra os cadastros (`SELECT`) com botões Alterar / Excluir  |
| `excluir.php`    | Faz o `DELETE` (recebe o id por POST)                        |
| `validacao.js`   | Validações em JavaScript + confirmação de exclusão           |
| `estilo.css`     | Estilo das páginas                                           |

## Como rodar (macOS)

```bash
brew install mysql php        # se ainda não estiverem instalados
mysql.server start            # ou: brew services start mysql

mysql -u root -p < banco.sql  # cria o banco e a tabela
```

Coloque a senha do root em `$senhaBanco` no `conexao.php`, depois:

```bash
php -S localhost:8000
```

Abra http://localhost:8000/formulario.php

## Validações

- **HTML5:** `required`, `type="email"`, `type="tel"` com `pattern`, `minlength`/`maxlength`, `pattern` da data.
- **JavaScript:** senha ≥ 6 e confirmação igual, data existente e não futura, pelo menos um interesse marcado, confirmação antes de excluir.
- **PHP:** todos os campos obrigatórios, formato do e-mail, e-mail duplicado, telefone, data válida e não futura, senhas, curso/turno/interesses dentro das opções permitidas.

Para testar só a validação do PHP, desative o JavaScript no navegador ou adicione `novalidate` na tag `<form>`.

## Segurança

- Consultas com *prepared statements* (PDO) — sem SQL injection.
- Senhas guardadas com `password_hash()` (mesma ideia do `senha.php`).
- Toda saída passa por `htmlspecialchars()` — sem XSS.
- Exclusão por POST, e redirecionamento após gravar (o F5 não reenvia o formulário).
