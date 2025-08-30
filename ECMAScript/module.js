console.log('Módulo importado');

// async
export function fetchDados() {
    console.log('Início do processamento');

    return new Promise(resolve => {
        setTimeout(() => {
            resolve('Executou');
        }, 3000);
    });
}

const dados = await fetchDados();  // contexto do módulo
//const dados = fetchDados(); 
console.log(dados);

console.log('fim do processamento');

/*
export async function aguardarPromessa() {
    console.log('Início do processamento');

    function fetchDados() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve('Executou');
            }, 3000);
        });
    }

    // aguardamos pelo processamento
    // no contexto da função
    const dados = await fetchDados(); 
    console.log(dados);

    console.log('fim do processamento');
}

aguardarPromessa();
*/