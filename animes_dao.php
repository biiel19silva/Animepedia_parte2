<?php

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
            $data['foto'] ?? null,
            $data['nome'],
            $data['idade'],
            $data['genero'],
            $data['anime'],
            $data['curiosidade']
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $new_id = $result['id'] ?? null;
        
        http_response_code(201);
        return array("message" => "Personagem criado com sucesso.", "id" => $new_id);
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao criar personagem: " . $e->getMessage());
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
        $anime = $stmt->fetch(PDO::FETCH_ASSOC);

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
            http_response_code(200); // Retorna 200 e um array vazio se não houver filmes
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

    $sql = "UPDATE animes SET foto = ?, nome = ?, idade = ?, genero = ?,  anime= ?, curiosidade = ? WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['foto'] ?? null,
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

?>
