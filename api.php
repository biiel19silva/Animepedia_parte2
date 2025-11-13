<?php
// api.php
// API RESTful Procedural para gerenciamento de animes com roteamento baseado em Query String.

// 1. Cabeçalhos e Configuração
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Inclui o arquivo de conexão (que usa PDO e PostgreSQL)
include_once 'dbconfig.php';

// Trata o preflight OPTIONS (necessário para CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Inicializa a conexão
$pdo = getDbConnection();

// Obtém o método HTTP e os dados de entrada
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true); // Para POST/PUT

// --- Lógica de Roteamento Baseada na Query String (Modelo: ?resource=animes&id=...) ---

// Obtém o recurso da query string (ex: 'animes')
$resource = $_GET['resource'] ?? '';

// Obtém o ID da query string (ex: '2')
$id = $_GET['id'] ?? null;

// Sanitiza o ID, caso exista
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
if (empty($id)) $id = null; // Garante que $id seja null se vazio ou inválido

// Funções CRUD para o recurso 'animes'

/**
 * Função CREATE (POST /api.php?resource=animes)
 */
function createAnime($pdo, $data) {
    if (empty($data['nome']) || empty($data['idade']) || empty($data['genero']) || empty($data['anime']) || empty($data['curiosidade'])) {
        http_response_code(400);
        return array("message" => "Dados incompletos: nome, idade, gênero, anime e curiosidade são obrigatórios.");
    }
    
    // ATENÇÃO: Para PostgreSQL, usamos RETURNING id para obter o ID inserido.
    $sql = "INSERT INTO animes (foto, nome, idade, genero, anime, curiosidade) VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING id";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['foto'] ?? null 
            $data['nome'],
            $data['idade'],
            $data['genero'],
            $data['anime'], 
            $data['curiosidade']
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $new_id = $result['id'] ?? null;
        
        http_response_code(201);
        return array("message" => "Anime criado com sucesso.", "id" => $new_id);
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao criar anime: " . $e->getMessage());
    }
}

/**
 * Função READ (GET /api.php?resource=animes ou GET /api.php?resource=animes&id=2)
 */
function readAnimes($pdo, $id) {
    if ($id) {
        // READ ONE
        $sql = "SELECT id, foto, nome, idade, genero, anime, curiosidade FROM animes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $filme = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($anime) {
            http_response_code(200);
            return $anime;
        } else {
            http_response_code(404);
            return array("message" => "Personagem não encontrado.");
        }
    } else {
        // READ ALL
        $sql = "SELECT id, foto, nome, idade, genero, anime, curiosidade FROM animes ORDER BY id DESC";
        $stmt = $pdo->query($sql);
        $animes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($animes) {
            http_response_code(200);
            return $animes;
        } else {
            http_response_code(200); // Retorna 200 e um array vazio se não houver personagens
            return [];
        }
    }
}

/**
 * Função UPDATE (PUT /api.php?resource=animes&id=2)
 */
function updateAnime($pdo, $id, $data) {
    if (!$id || empty($data['nome']) || empty($data['idade']) || empty($data['genero']) || empty($data['anime']) || empty($data['curiosidade'])) {
        http_response_code(400);
        return array("message" => "Dados incompletos ou ID ausente.");
    }

    $sql = "UPDATE animes SET foto = ?, nome = ?, idade = ?, genero = ?, anime = ?, curiosidade = ? WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['foto'] ?? null 
            $data['nome'],
            $data['idade'],
            $data['genero'],
            $data['anime'], 
            $data['curiosidade'],
            $id
        ]);
        
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            return array("message" => "Personagem atualizado com sucesso.");
        } else {
            http_response_code(404);
            return array("message" => "Personagem não encontrado ou nenhum dado para atualizar.");
        }
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao atualizar personagem: " . $e->getMessage());
    }
}

/**
 * Função DELETE (DELETE /api.php?resource=animes&id=2)
 */
function deleteAnime($pdo, $id) {
    if (!$id) {
        http_response_code(400);
        return array("message" => "ID do personagem é obrigatório para exclusão.");
    }

    $sql = "DELETE FROM animes WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            return array("message" => "Personagem excluído com sucesso.");
        } else {
            http_response_code(404);
            return array("message" => "Personagem não encontrado.");
        }
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao excluir personagem: " . $e->getMessage());
    }
}

// --- Roteamento Principal Modificado ---

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
