document.addEventListener('DOMContentLoaded', function() { 

     

    const body = document.body; 

    const btnAlternarTema = document.getElementById('alternaTema');  

 

    // ---------------------------------------------------- 

    // FUNÇÃO 1: APLICAR TEMA AO CARREGAR A PÁGINA 

    // ---------------------------------------------------- 

    function carregarTema() { 

        // 1. Tenta obter o tema salvo no localStorage. Padrão é 'dark'. 

        const temaSalvo = localStorage.getItem('preferenciaTema') || 'dark'; 

 

        if (temaSalvo === 'light') { 

            body.classList.add('tema-claro'); 

            if (btnAlternarTema) { 

                btnAlternarTema.textContent = 'Alternar para Tema Escuro'; 

            } 

        } else { 

            body.classList.remove('tema-claro'); 

            if (btnAlternarTema) { 

                btnAlternarTema.textContent = 'Alternar para Tema Claro'; 

            } 

        } 

    } 

 

    // ---------------------------------------------------- 

    // FUNÇÃO 2: SALVAR O TEMA QUANDO ELE MUDA 

    // ---------------------------------------------------- 

    function alternarESalvarTema() { 

        // Alterna (liga/desliga) a classe 'tema-escuro' no body 

        body.classList.toggle('tema-claro'); 

 

        let novoTema; 

 

        if (body.classList.contains('tema-claro')) { 

            novoTema = 'light'; 

            btnAlternarTema.textContent = 'Alternar para Tema Escuro'; 

        } else { 

            novoTema = 'dark'; 

            btnAlternarTema.textContent = 'Alternar para Tema Claro'; 

        } 

 

        // Salva a nova preferência no localStorage 

        localStorage.setItem('preferenciaTema', novoTema); 

    } 

     

    // ---------------------------------------------------- 

    // INICIALIZAÇÃO 

    // ---------------------------------------------------- 

 

    // 1. Carrega o tema imediatamente ao carregar a página 

    carregarTema(); 

 

    // 2. Adiciona o evento de clique APENAS se o botão existir na página 

    if (btnAlternarTema) { 

        btnAlternarTema.addEventListener('click', alternarESalvarTema); 

    } 

}); 
