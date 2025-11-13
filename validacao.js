// =================================== 
// PARTE 1: A "Chave Mágica" para o E-mail (Regex) 
// =================================== 

// 'emailRegex' é uma "receita" que o computador usa para saber se algo 
// parece um e-mail. Ela verifica: 
// 1. Algo no começo (o nome de usuário). 
// 2. O símbolo @ (arroba). 
// 3. Algo depois do @ (o domínio, como gmail). 
// 4. Um ponto final (.). 
// 5. Algo no final (o .com, .br, etc.). 

const emailRegex = /^[a-zA-Z]+\.[a-zA-Z]+@net\.com$/;
const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/; 

// =================================== 
// PARTE 2: A Função de Verificação 
// =================================== 

/** 
 * Objetivo: Checar se o valor no campo de e-mail é válido. 
 * @param {HTMLElement} campoe - O campo de texto do e-mail. 
 * @returns {boolean} - 'true' se for válido, 'false' se não for. 
 */ 

function validarEmail(campoe) { 
    const email = campoe.value; 

    // Usamos a "receita" (emailRegex) para testar o e-mail. 
    if (emailRegex.test(email)) { 
        // SE VÁLIDO: 
        campoe.style.border = '1px solid green'; // Borda verde (OK!) 
        campoe.setCustomValidity('');           // Tira qualquer aviso de erro. 

        return true; 

    } else { 
        // SE INVÁLIDO: 
        campoe.style.border = '2px solid red';  // Borda vermelha (ERRO!) 

        // Prepara uma mensagem de erro e a mostra ao aluno: 
        const mensagemErro = 'Por favor, insira um endereço de e-mail válido.'; 
        campoe.setCustomValidity(mensagemErro); 
        //campo.reportValidity(); // Faz o navegador mostrar a caixa de erro. 

        return false; 
    } 
} 

/** 
 * Objetivo: Checar se o valor no campo de cpf é válido. 
 * @param {HTMLElement} campoc - O campo de texto do cpf. 
 * @returns {boolean} - 'true' se for válido, 'false' se não for. 
 */ 

function validarCPF(campoc) { 
    const cpf = campoc.value; 

    // Usamos a "receita" (emailRegex) para testar o e-mail. 
    if (cpfRegex.test(cpf)) { 
        // SE VÁLIDO: 
        campoc.style.border = '1px solid green'; // Borda verde (OK!) 
        campoc.setCustomValidity('');           // Tira qualquer aviso de erro. 

        return true; 

    } else { 
        // SE INVÁLIDO: 
        campoc.style.border = '2px solid red';  // Borda vermelha (ERRO!) 

        // Prepara uma mensagem de erro e a mostra ao aluno: 
        const mensagemErro = 'Por favor, insira um endereço de e-mail válido.'; 
        campoc.setCustomValidity(mensagemErro); 
        //campo.reportValidity(); // Faz o navegador mostrar a caixa de erro. 

        return false; 
    } 
} 

// =================================== 
// PARTE 3: Onde o Programa Começa a Funcionar 
// =================================== 

// Espera que a página HTML (o 'documento') esteja pronta para começar. 

document.addEventListener('DOMContentLoaded', function() { 

    // Acha o campo de e-mail na página pelo ID 'id_email'. 
    const campoEmail = document.getElementById('id_email'); 
    const campoCPF = document.getElementById('id_cpf');

    // --- Ação 1: Checagem Rápida (Saindo do Campo) --- 
    // Sempre que o aluno sai do campo (evento 'blur'), checamos o e-mail. 

    campoEmail.addEventListener('blur', function() { 
        validarEmail(campoEmail); 
    }); 

campoCPF.addEventListener('blur', function() {
    validarCPF(campoCPF);
});
})
