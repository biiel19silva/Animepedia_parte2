-- Cria um banco de dados com o nome animepedia
CREATE DATABASE animepedia
    CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;

-- Conecta com o banco de dados recém criado
USE animepedia;

-- Cria uma tabela chamada animes com os campos id, foto, nome, idade, genero, anime, curiosidade
CREATE TABLE animes (

    id INT AUTO_INCREMENT PRIMARY KEY,
    foto TEXT,
    nome VARCHAR(255) NOT NULL,
    idade INT,
    genero VARCHAR(100),
    anime VARCHAR(255) NOT NULL,
    curiosidade TEXT
);

-- Insere 5 animes na tabela animes
INSERT INTO animes (foto, nome, idade, genero, anime, curiosidade) VALUES
('./img/Daiki Aomine.webp', 'Daiki Aomine', '16', 'Masculino', 'Kuroko no basket', 'Aomine foi o primeiro personagem a ser mostrado a entrar na habilidade chamada 'astral' dentro do anime.'),
('./img/Kakashi Hatake do Sharingan.jpg', 'Kakashi Hatake', '31', 'Masculino', 'Naruto/Naruto Shipudden/Boruto', 'Kakashi é o único personagem que não vem do clã Uchiha que consegue usar o Susano´o.'),
('./img/Kyojurou Rengoku.webp', 'Kyojurou Rengoku', '20', 'Masculino', 'Demon Slayer', 'Apesar de morrer muito cedo, Rengoku é um dos personagens mais amados pelos fãs do anime.'),
('./img/Shoyo Hinata.webp', 'Shoyo Hinata', '17', 'Masculino', 'Haikyuu!!', 'Hinata tem apenas 1,62 m de altura, apesar disso é um jogador muito rápido e explosivo, com saltos quase sobre-humanos, sendo uma peça essencial no time do Karasuno.'),
('./img/Tanjiro Kamado.jpg', 'Tanjiro Kamado', '25', 'Masculino', 'Demon Slayer', 'Apesar de ser um caçador de oni, Tanjiro aparentemente é o personagem que mais demonstra compaixão pelos oni que enfrenta.');
