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
        <h2>Serviço de atendimento ao cliente</h2>
        <p>Envie uma mensagem e responderemos logo.</p>

        <form action="#" method="post">
          
        <label for="id_nome">Nome do cliente:</label><br> 
        <input type="text" id="id_nome" name="nome"><br><br>

        <label for="id_assunto">Assunto da mensagem:</label><br> 
        <input type="text" id="id_assunto" name="assunto"><br><br>

        <label for="id_email">Email:</label><br> 
        <input type="text" id="id_email" name="email"><br><br>

        <label for="id_cpf">CPF:</label><br> 
        <input type="text" id="id_cpf" name="cpf"><br><br>       
        
        <label for="id_mensagem">Mensagem:</label><br>
        <textarea name="mensagem" id="id_mensagem"></textarea><br><br>
        <button type="submit">Enviar</button>
            
        </form>

    </main>
    <?php include 'footer.php'; ?>
    <script src="js/validacao.js"></script>
    <script src="js/tema.js"></script>
</body>
</html>
