$(function() {
    $( "#dialogInformacao" ).dialog({
            autoOpen: false,
            width: 450,
            show: 'explode',
            hide: 'explode',
            title: 'Mensagem',
            modal: true,
            buttons: [
                    {
                            text: "Ok",
                            id: "btnOk",
                            click: function() {
                                    $( this ).dialog( "close" );
                            }
                    }
            ]
    });
    $( "#dialogAdiantamento" ).dialog({
            autoOpen: false,
            width: 450,
            show: 'explode',
            hide: 'explode',
            title: 'Mensagem',
            modal: true,
            buttons: [
                    {
                            text: "Ok",
                            id: "btnOk",
                            click: function() {
                                    $( this ).dialog( "close" );
                            }
                    }
            ]
    });
    $( "#Listagem" ).dialog({
        autoOpen: true,
        width: '70%',
        position: [100,0],
        title: 'Fluxo de caixa',
        close: function(ev, ui) { window.location='../../Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu'; }
    });
    $( "#dtaVendaInicio" ).datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    $( "#dtaVendaFim" ).datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    $("#btnPesquisa").click(function(){
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosFluxoCaixaController.php', {
            method: 'BuscaFluxo',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val()}, function(data){
            data = eval('('+data+')');
            if (data[0].dadosFluxo!=null){
                dadosFluxo = data[0].dadosFluxo;
                dadosDespesasFixas = data[0].dadosDespesasFixas;
                dadosDespesasRotativas = data[0].dadosDespesasRotativas;
                dadosReceitas = data[0].dadosReceitas;
                //$("#conteudo").html('');
                tabela = '';
                for(i=0;i<dadosFluxo.length;i++){
                    vlrDespesaFixa = 0;
                    vlrDespesaRotativa =0;
                    vlrReceita = 0;
                    tabela += '<table width="100%">';
                    tabela += '   <tr><td width="5%"><a href="javascript:mostraTR('+i+');"><img class="imagem" id="imagem'+i+'" src="../../Resources/images/plus.png" width="15px" height="15px"></a></td>';
                    tabela += '       <td>Data: '+dadosFluxo[i].DTA_MOVIMENTACAO+'</td></tr>';
                    tabela += '   <tr class="esconde"id="'+i+'" style="display:none;"><td colspan="2">';
                    tabela += '           <table width="100%">';
                    tabela += '               <tr><td align="left" class="TDTitulo">Total de Despesas Fixas: '+dadosFluxo[i].VLR_FIXA+'</td></tr>';
                    tabela += '               <tr><td align="left" class="TDTitulo">Total de Despesas Rotativas: '+dadosFluxo[i].VLR_ROTATIVA+'</td></tr>';
                    tabela += '               <tr><td align="left" class="TDTitulo">Total de Receitas: '+dadosFluxo[i].VLR_RECEITA+'</td></tr>';
                    tabela += '               <tr id="'+i+'"><td align="left" class="TDTitulo">Despesas Fixas</td></tr>';
                    tabela += '               <tr><td>';
                    tabela += '                   <table width="40%" cellspacing="0" class="TabelaCabecalho">';
                    tabela += '                       <tr><td class="TDTitulo">Descrição</td>';
                    tabela += '                           <td class="TDTitulo" align="right">Valor</td>';
                    tabela += '                       </tr>';
                    corLinha = "E8E8E8";
                    if(data[0].dadosDespesasFixas!=null){
                        for(j=0;j<dadosDespesasFixas.length;j++){
                            if (corLinha=="white"){
                                corLinha="E8E8E8";
                            }else{
                                corLinha="white";
                            }
                            if (dadosFluxo[i].DTA_MOVIMENTACAO==dadosDespesasFixas[j].DTA_MOVIMENTACAO){
                                tabela += '<tr bgcolor="'+corLinha+'" class="trcor"><td>'+dadosDespesasFixas[j].DSC_MOVIMENTACAO+'</td>';
                                tabela += '<td align="right">R$ '+dadosDespesasFixas[j].VLR_MOVIMENTACAO+'</td></tr>';
                            }
                        }
                    }
                    tabela += '</table></tr></td>';
                    tabela += '<tr><td align="left" class="TDTitulo">Despesas Rotativas</td></tr>';
                    tabela += '<tr><td>';
                    tabela += '<table width="40%" cellspacing="0" class="TabelaCabecalho">';
                    tabela += '<tr><td class="TDTitulo">Descrição</td>';
                    tabela += '<td class="TDTitulo" align="right">Valor</td></tr>';
                    corLinha = "E8E8E8";
                    if (data[0].dadosDespesasRotativas!=null){
                        for(j=0;j<dadosDespesasRotativas.length;j++){
                            if (corLinha=="white"){
                                corLinha="E8E8E8";
                            }else{
                                corLinha="white";
                            }
                            if (dadosFluxo[i].DTA_MOVIMENTACAO==dadosDespesasRotativas[j].DTA_MOVIMENTACAO){
                                tabela += '<tr bgcolor="'+corLinha+'" class="trcor"><td>'+dadosDespesasRotativas[j].DSC_MOVIMENTACAO+'</td>';
                                tabela += '<td align="right">R$ '+dadosDespesasRotativas[j].VLR_MOVIMENTACAO+'</td></tr>';
                            }
                        }
                    }
                    tabela += '</table></tr></td>';
                    tabela += '<tr><td align="left" class="TDTitulo">Receitas</td></tr>';
                    tabela += '<tr><td><table width="40%" cellspacing="0" class="TabelaCabecalho"><tr><td class="TDTitulo">Descrição</td>';
                    tabela += '<td class="TDTitulo" align="right">Valor</td>';
                    tabela += '<td class="TDTitulo" align="right">&nbsp;</td></tr>';
                    corLinha = "E8E8E8";
                    if (data[0].dadosReceitas!=null){
                        for(j=0;j<dadosReceitas.length;j++){
                            if (corLinha=="white"){
                                corLinha="E8E8E8";
                            }else{
                                corLinha="white";
                            }
                            if (dadosFluxo[i].DTA_MOVIMENTACAO==dadosReceitas[j].DTA_MOVIMENTACAO){
                                tabela += '<tr bgcolor="'+corLinha+'" class="trcor"><td>'+dadosReceitas[j].TPO_CLASSIFICACAO+'</td>';
                                tabela += '<td align="right">R$ '+dadosReceitas[j].VLR_MOVIMENTACAO+'</td>';
                                tabela += '<td align="right">';
                                if ((dadosReceitas[j].TPO_CLASSIFICACAO_RECEITA=='CC') ||
                                    (dadosReceitas[j].TPO_CLASSIFICACAO_RECEITA=='CH') ||
                                    (dadosReceitas[j].TPO_CLASSIFICACAO_RECEITA=='CD')){
                                    tabela += '    <a href="javascript:CarregaAdiantamento('+dadosReceitas[j].COD_MOVIMENTACAO+')">';
                                    tabela += '        <img src="../../Resources/images/Adiantamento.png" width="20" heigth="20" title="Adiantamento de receita">';
                                    tabela += '    </a>';
                                }else{
                                    tabela += '&nbsp;'
                                }
                                tabela += '</td></tr>';
                            }
                        }
                    }
                    tabela += '</table></td></tr></table></td></tr>';
                    //tabela += '<tr><td><br></td></tr>';
                }
                tabela += '<tr><td align="left" class="TDTitulo" colspan="2">Total Geral de Despesas Fixas: R$ '+data[0].vlrTotalFixa+'</td></tr>';
                tabela += '<tr><td align="left" class="TDTitulo" colspan="2">Total Geral de Despesas Rotativas: R$ '+data[0].vlrTotalRotativa+'</td></tr>';
                tabela += '<tr><td align="left" class="TDTitulo" colspan="2">Total Geral de Receitas: R$ '+data[0].vlrTotalReceita+'</td></tr></table>';
                console.log(tabela);
                $("#conteudo").html(tabela);
            }else{
                $("#conteudo").html("Sem Dados para a Pesquisa!");
            }
        });
    })
});
function mostraTR(codtr){
    if (codtr!=$("#tr").val()){
        $(".esconde").hide();
        $(".imagem").attr('src','../../Resources/images/plus.png');
        $("#tr").val(codtr);
    }
    if (document.getElementById(codtr).style.display == "none"){
        $("#"+codtr).show('slow');
        $("#imagem"+codtr).attr('src', '../../Resources/images/minus.png');
    }else{
        $("#"+codtr).hide('slow');
        $("#imagem"+codtr).attr('src', '../../Resources/images/plus.png');
    }
}

function CarregaAdiantamento(codMovimentacao, indAdiantamento, vlrAdiantamento, dtaAdiantamento){
    $("#codMovimentacao").val(codMovimentacao);
    if (indAdiantamento=='S'){
        $("#vlrAdiantamento").val(vlrAdiantamento);
        $("#dtaAdiantamento").val(dtaAdiantamento);
        $("#indAdiantamento").val("S");
    }
    $("#dialogAdiantamento").dialog('open');
}