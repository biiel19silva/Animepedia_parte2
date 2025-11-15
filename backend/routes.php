<?php

$response = array();

// 1. Verifica se o recurso é 'animes'
if ($resource !== 'animes') {
    http_response_code(404);
    $response = array("message" => "Recurso não encontrado ou ausente. Use ?resource=animes");
} else {
    // 2. Roteia com base no método HTTP e na presença do ID
    switch ($method) {
        case 'GET':
            // Rota: GET api.php?resource=animes ou GET api.php?resource=animes&id=2
            $response = readAnimes($pdo, $id);
            break;
            
        case 'POST':
            // Rota: POST api.php?resource=animes (ID não deve estar na query string para criação)
            if ($id) {
                http_response_code(405); // Método POST não deve ter ID no caminho/query
                $response = array("message" => "Método não permitido para esta rota. Use POST api.php?resource=animes.");
            } else {
                $response = createAnime($pdo, $data);
            }
            break;

        case 'PUT':
            // Rota: PUT api.php?resource=animes&id=2 (ID é obrigatório na query string)
            if ($id) {
                $response = updateAnime($pdo, $id, $data);
            } else {
                http_response_code(400);
                $response = array("message" => "ID do personagem é obrigatório na query string para o método PUT (ex: ?resource=animes&id=123).");
            }
            break;
            
        case 'DELETE':
            // Rota: DELETE api.php?resource=animes&id=2 (ID é obrigatório na query string)
            if ($id) {
                $response = deleteAnime($pdo, $id);
            } else {
                http_response_code(400);
                $response = array("message" => "ID do personagem é obrigatório na query string para o método DELETE (ex: ?resource=animes&id=123).");
            }
            break;

        default:
            http_response_code(405); // Method Not Allowed
            $response = array("message" => "Método não permitido para este recurso.");
            break;
    }
}

// 3. Retorna a Resposta como JSON
echo json_encode($response);

?>
