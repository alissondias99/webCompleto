$(document).ready(() => {

    $('#documentacao').on('click', () => {
        $.post('documentacao.html', data => {
            $('#pagina').html(data)
        })
    })

    $('#suporte').on('click', () => {
        $.post('suporte.html', data => {
            $('#pagina').html(data)
        })

    })

    $('#competencia').on('change', e => {


        let competencia = $(e.target).val()

        $.ajax({ // usado para definir um serie de itens
            type: 'GET', // o metodo usado para tranferir os dados
            url: 'app.php', // para onde os dados estão sendo passados
            data: `competencia=${competencia}`, // quais dados são
            dataType: 'json', // muda o formato do objeto na momento do envio
            success: dados => {
                $("#numeroVendas").html(dados.numeroVendas)
                $("#totalVendas").html(dados.totalVendas)
                $("#clienteAtivos").html(dados.clienteAtivo)
                $("#clientesInativos").html(dados.clienteInativo)
                $("#totalDespesas").html(dados.total_despesas)
                $("#totalReclamacao").html(dados.total_reclamacao)
                $("#totalElogio").html(dados.total_elogio)
                $("#totalSugestao").html(dados.total_sugestao)
            }, // caso tenha sucesso no envio
            error: erro => {console.log(erro)} // caso tenha erro no envio
        })

    });

})