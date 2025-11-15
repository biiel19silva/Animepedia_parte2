// js/anime.js

const action = window.ANIME_ACTION;
const animeId = window.ANIME_ID;

/*
// Se estiver editando, carrega os dados do personagem
if (action === "editar" && animeId) {
    fetch(`http://localhost/animepedia/backend/api.php?resource=animes&id=${animeId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById("foto").value = data.foto;
            document.getElementById("nome").value = data.nome;
            document.getElementById("idade").value = data.idade;
            document.getElementById("genero").value = data.genero;
            document.getElementById("anime").value = data.anime;
            document.getElementById("curiosidade").value = data.curiosidade;
        })
        .catch(err => {
            document.getElementById("modalMessage").innerText = "Erro ao carregar dados do personagem.";
            document.getElementById("modalOverlay").style.display = "flex";
        });
}
*/

// SUBMIT DINÂMICO (POST ou PUT)
document.getElementById("form_anime").addEventListener("submit", async function(e) {
    e.preventDefault();

    const payload = {
        foto: document.getElementById("foto").value,
        nome: document.getElementById("nome").value,
        idade: document.getElementById("idade").value,
        genero: document.getElementById("genero").value,
        anime: document.getElementById("anime").value,
        curiosidade: document.getElementById("curiosidade").value
    };

    let url = "http://localhost/animepedia/backend/api.php?resource=animes";
    let method = "POST";

    if (action === "editar") {
        method = "PUT";
        url += `&id=${animeId}`;
    }

    try {
        const response = await fetch(url, {
            method,
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        document.getElementById("modalMessage").innerText = result.message;
        document.getElementById("modalOverlay").style.display = "flex";

    } catch (error) {
        document.getElementById("modalMessage").innerText =
            action === "editar"
                ? "Erro ao atualizar personagem."
                : "Erro ao cadastrar personagem.";
        document.getElementById("modalOverlay").style.display = "flex";
    }
});

// Botão OK do modal → redireciona para catálogo
document.getElementById("btnModalOK").addEventListener("click", function() {
    window.location.href = "http://localhost/animepedia/catalogo.php";
});