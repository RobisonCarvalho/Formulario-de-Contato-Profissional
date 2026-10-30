
const form = document.querySelector("#contactForm");
const feedback = document.querySelector("#feedback");
const botao = form.querySelector('button[type="submit"]');

form.addEventListener("submit", async function(event) {

    event.preventDefault();

    if (!form.reportValidity()) {
        return;
    }

    botao.disabled = true;
    botao.textContent = "A enviar...";
    feedback.textContent = "";

    try {

        const resposta = await fetch("php/send.php", {
            method: "POST",
            body: new FormData(form),
            headers: {
                "Accept": "application/json"
            }
        });

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.success) {
            throw new Error(
                resultado.message || "Erro ao processar formulário."
            );
        }

        feedback.textContent = resultado.message;
        feedback.style.color = "#198754";

        form.reset();

    } catch (erro) {

        feedback.textContent = erro.message;
        feedback.style.color = "#d32f2f";

    } finally {

        botao.disabled = false;
        botao.textContent = "Enviar mensagem";

    }

});
