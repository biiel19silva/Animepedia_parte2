<?php
// anime_form.php

$action = $_GET['action'] ?? 'novo';
$id = $_GET['id'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animepedia</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>
    <main>
        <h2><?= $action == 'editar' ? 'Editar Personagem' : 'Cadastro de novo Personagem' ?></h2>
        <form id="form_anime">
            <label for="foto">Foto (nome da imagem)</label>
            <input type="text" id="foto" value="<?= htmlspecialchars($_GET['foto'] ?? '') ?>" required>

            <label for="nome">Nome</label>
            <input type="text" id="nome" value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>" required>

            <label for="idade">Idade</label>
            <input type="text" id="idade" value="<?= htmlspecialchars($_GET['idade'] ?? '') ?>" required>

            <label for="genero">Gênero</label>
            <input type="text" id="genero" value="<?= htmlspecialchars($_GET['genero'] ?? '') ?>" required>

            <label for="anime">Anime</label>
            <input type="text" id="anime" value="<?= htmlspecialchars($_GET['anime'] ?? '') ?>" required>

            <label for="curiosidade">Curiosidade</label>
            <input type="text" id="curiosidade" value="<?= htmlspecialchars($_GET['curiosidade'] ?? '') ?>" required>

            <button type="submit">
                <?= $action == 'editar' ? 'Salvar Alterações' : 'Cadastrar Personagem' ?>
            </button>
        </form>

    </main>

    <?php include 'footer.php'; ?>

    <!-- MODAL -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h3 id="modalMessage">Mensagem aqui</h3>
            <button id="btnModalOK">OK</button>
        </div>
    </div>

    <script>
        window.ANIME_ACTION = "<?= $action ?>";
        window.ANIME_ID = "<?= $id ?>";
    </script>

    <script src="js/tema.js"></script>
    <script src="js/anime.js"></script>
</body>
</html>
