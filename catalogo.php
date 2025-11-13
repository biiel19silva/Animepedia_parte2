<?php
// Inclui o arquivo de biblioteca que contém as funções getBaseUrl() e fetchAnimesFromApi()
include_once 'backend/lib.php';

// 1. Obtem a URL base e construir a URL completa para a API
$base_url = getBaseUrl();
$api_url = $base_url . '/backend/api.php?resource=animes';

// 2. Busca os dados da API
$result = fetchAnimesFromApi($api_url);
$filmes = $result['animes'];
$error = $result['error'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animepedia</title>
    <style type="text/css">
        @import url("styles/style.css");
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>
    <main>
        <h2>Catálogo de personagens</h2>
        <p>Veja abaixo os personagens já cadastrados em nosso banco de dados.</p>
        <!--A tag table significa tabela-->
        <!--A tag th é a linha para cabeçalho (table header)-->
        <!--A tag tr é a linha para os dados (table row)-->
        <!--A tag td é a coluna para os dados-->
        <!--A tag tl é a coluna para os dados-->
        <table id="tabela" border="1"> <!--Border serve para colocar borda na tabela-->
            <thead>
                <tr>
                    <th>Foto:</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Gênero</th>   
                    <th>Anime</th> 
                    <th>Curiosidade</th>               
                </tr>
            </thead>
            <tbody id="corpo-tabela-animes">
                  <?php if ($error): ?>
                    <!-- Exibe mensagem de erro -->
                    <tr style="color: red; border: 1px solid red; padding: 10px;">
                        <td colspan="3">Erro</td>
                        <td colspan="3"><p><?php echo htmlspecialchars($error); ?></p></td>
                    </tr>
                <?php elseif (!empty($animes)): ?>
                    <?php foreach ($animes as $anime): ?>
                        <tr>
                            <td>
                                <?php
                                    $url = htmlspecialchars($anime['foto'] ?? '');
                                    if (!empty($url)):
                                ?>
                                    <!-- CORREÇÃO 3: Exibe a URL como uma imagem <img> -->
                                    <img src="<?php echo $url; ?>" 
                                        alt="<?php echo htmlspecialchars($anime['nome'] ?? 'Foto'); ?>"
                                    />
                                    <!-- Fallback para caso a imagem não carregue -->
                                    <span style="display: none; color: gray;">Imagem não carregada.</span>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($filme['nome'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['idade'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['genero'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['anime'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['curiosidade'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['id'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Não foi possível carregar o catálogo de personagens. Verifique a URL da API.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <?php include 'footer.php'; ?>
    <script src="js/tema.js"></script>
</body>
  
</html>
