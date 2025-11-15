function deleteAnime(id) {
    if (!confirm("Tem certeza que deseja excluir este personagem?")) {
        return;
    }

    fetch(`http://localhost/animepedia/backend/api.php?resource=animes&id=${id}`, {
        method: "DELETE"
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || "Personagem excluído.");

        // Recarrega a página após deletar
        window.location.reload();
    })
    .catch(err => {
        alert("Erro ao excluir o personagem.");
        console.error(err);
    });
}