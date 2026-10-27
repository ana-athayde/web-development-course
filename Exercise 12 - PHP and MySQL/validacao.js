// Validações em JavaScript (complementam o HTML5 e o PHP)

document.addEventListener("DOMContentLoaded", () => {

    // ----- Formulário de cadastro -----
    const form = document.getElementById("form-cadastro");

    if (form) {
        const editando = form.dataset.editando === "1";
        const caixaErros = document.getElementById("erros-js");

        form.addEventListener("submit", (evento) => {
            const erros = [];

            const senha = form.elements["senha"].value;
            const confirmar = form.elements["confirmar_senha"].value;

            // Na alteração, senha em branco = manter a atual
            if (!editando || senha !== "") {
                if (senha.length < 6) {
                    erros.push("A senha deve ter pelo menos 6 caracteres.");
                }
                if (senha !== confirmar) {
                    erros.push("As senhas não conferem.");
                }
            }

            // HTML5 só checa o padrão dd/mm/aaaa; aqui checa se a data existe
            const data = form.elements["data"].value.trim();
            if (!dataValida(data)) {
                erros.push("Informe uma data de nascimento válida (dd/mm/aaaa) que não esteja no futuro.");
            }

            // HTML5 não tem "pelo menos um checkbox marcado"
            if (!form.querySelector('input[name="interesses[]"]:checked')) {
                erros.push("Selecione pelo menos uma área de interesse.");
            }

            if (erros.length > 0) {
                evento.preventDefault();
                caixaErros.innerHTML = "<ul>" + erros.map((e) => `<li>${e}</li>`).join("") + "</ul>";
                caixaErros.hidden = false;
                window.scrollTo({ top: 0, behavior: "smooth" });
            } else {
                caixaErros.hidden = true;
            }
        });
    }

    // ----- Confirmação de exclusão na listagem -----
    document.querySelectorAll(".form-excluir").forEach((f) => {
        f.addEventListener("submit", (evento) => {
            if (!confirm(`Excluir o cadastro de ${f.dataset.nome}?`)) {
                evento.preventDefault();
            }
        });
    });
});


function dataValida(texto) {
    const partes = /^(\d{2})\/(\d{2})\/(\d{4})$/.exec(texto);
    if (!partes) {
        return false;
    }

    const dia = Number(partes[1]);
    const mes = Number(partes[2]);
    const ano = Number(partes[3]);
    const data = new Date(ano, mes - 1, dia);

    return data.getFullYear() === ano &&
           data.getMonth() === mes - 1 &&
           data.getDate() === dia &&
           data <= new Date();
}
