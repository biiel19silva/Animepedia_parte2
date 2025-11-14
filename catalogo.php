<?php

/**
 * Busca a lista de filmes da API RESTful, trata a resposta e ordena os filmes.
 * @param string $api_url URL completa do endpoint da API.
 * @return array Um array associativo contendo:
 * - 'filmes': Array de filmes (ou array vazio em caso de erro/sem dados).
 * - 'error': String com a mensagem de erro (ou null se a busca foi bem-sucedida).
 */
function fetchAnimesFromApi(string $api_url): array {
    $animes = [];
    $error = null;

    try {
        // Inicializa a sessão cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Executa a requisição
        $response = curl_exec($ch);
        
        // Verifica por erros de cURL
        if (curl_errno($ch)) {
            throw new Exception("Erro cURL: " . curl_error($ch));
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Decodifica a resposta JSON (JSON_UNESCAPED_UNICODE para tratar acentuação)
        $data = json_decode($response, true, 512, JSON_UNESCAPED_UNICODE);

        if ($http_code === 200) {
            if (is_array($data) && count($data) > 0 && isset($data[0]['id'])) {
                $animes = $data;
                
                // Ordenação local dos filmes em ordem crescente por 'id'.
                usort($animes, function($a, $b) {
                    return $a['id'] <=> $b['id'];
                });

            } elseif (is_array($data) && empty($data)) {
                $error = "Nenhum personagem cadastrado na base de dados.";
            } else {
                 $error = "Formato de dados inesperado da API.";
            }
        } else {
            // Trata códigos de erro HTTP diferentes de 200
            $error_message = $data['message'] ?? "Erro HTTP: " . $http_code;
            throw new Exception("Falha ao buscar dados: " . $error_message);
        }

    } catch (Exception $e) {
        // Captura e armazena o erro da exceção
        $error = $e->getMessage();
    }
    
    // Retorna o array com os dados e o status
    return ['animes' => $animes, 'error' => $error];
}


// Inclui o arquivo de biblioteca que contém as funções getBaseUrl() e fetchFilmesFromApi()
include_once 'backend/lib.php';

// 1. Obtem a URL base e construir a URL completa para a API
$api_url = 'http://localhost/Animepedia-ara0062-quarta-main/backend/api.php?resource=animes';

// 2. Busca os dados da API
$result = fetchAnimesFromApi($api_url);
$animes = $result['animes'];
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
        <table id="tabela" border="1"> 
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
