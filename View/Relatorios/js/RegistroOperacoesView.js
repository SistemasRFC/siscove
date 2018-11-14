$(function() {
    $("#dtaReferencia").jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaReferencia" ).jqxDateTimeInput("clear");
    $("#btnPesquisaRef").click(function(){
        $.post('../../Controller/Relatorios/RelatorioOperacoesController.php',
            {method: 'ListarRegistros',
            codVenda: $("#codVendaReferencia").val(),
            dtaReferencia: $("#dtaReferencia").val()}, function(data){

            data = eval('('+data+')');
            if (data[0]!= null || data[1]!= null || data[2]!=null){
                MontaTabela(data);
            }else{
                MontaTabela(data);
                $( "#dialogInformacao" ).jqxWindow( "open" );
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Sem dados para essa consulta!');
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow( "close" );
                },3000);
            }
        });
    });
});

function MontaTabela(data){
    $("#Registros").html('');
    tabela = '<table align="center" width="80%" class="TabelaConteudo" style="border: 1px solid #000000;"';
    var registro;
    corLinha = 'white';
    primeira = true;
    if (data[0]!=null){
    tabela += '<tr>';
        tabela += '<td>';
            tabela += '<table align="center" width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
                tabela += '<tr>';
                tabela += '<td colspan="5" align="center" class="TDTituloCabecalho"> Log de Vendas </td>';
                tabela += '</tr>';
                tabela += '<tr>';
                tabela += '     <td width="18%" class="TDTitulo">';
                tabela += '         Número da Operação';
                tabela += '     </td>';
                tabela += '     <td width="17%" class="TDTitulo">';
                tabela += '         Código da Venda';
                tabela += '     </td>';
                tabela += '     <td width="23%" class="TDTitulo">';
                tabela += '         Usuário';
                tabela += '     </td>';
                tabela += '     <td width="22%" class="TDTitulo">';
                tabela += '         Data da Operação';
                tabela += '     </td>';
                tabela += '     <td width="20%" class="TDTitulo">';
                tabela += '         Tipo de Operação';
                tabela += '     </td>';
                tabela += ' </tr>';
                registro = data[0];
                for(var i=0;i<registro.length;i++){
                    if ( corLinha === "white" ){
                        corLinha="E8E8E8";
                    }else{
                        corLinha="white";
                    }
                tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
                tabela += '    <td>'+registro[i].COD_OPERACAO+'</td>';
                tabela += '    <td>'+registro[i].COD_VENDA+'</td>';
                tabela += '    <td>'+registro[i].COD_USUARIO+'</td>';
                tabela += '    <td>'+registro[i].DTA_OPERACAO+'</td>';
                tabela += '    <td align="right">'+registro[i].TPO_OPERACAO+'</td>';
                tabela += ' </tr>';
                }
            tabela += '  </table>';
        tabela += '</td>';
    tabela += '</tr>';
    }
    if (data[1]!=null){
    tabela += '<tr>';
        tabela += '<td>';
            tabela += '<table align="center" width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
            tabela += '<tr>';
            tabela += '<td colspan="8" align="center" class="TDTituloCabecalho"> Log de Produtos </td>';
            tabela += '</tr>';
            tabela += '<tr>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Número da Operação';
            tabela += '     </td>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Cod. Venda';
            tabela += '     </td>';
            tabela += '     <td width="17%" class="TDTitulo">';
            tabela += '         Produto';
            tabela += '     </td>';
            tabela += '     <td width="11%" class="TDTitulo">';
            tabela += '         Qtd. Produto';
            tabela += '     </td>';
            tabela += '     <td width="13%" class="TDTitulo">';
            tabela += '         Valor do Produto';
            tabela += '     </td>';
            tabela += '     <td width="15%" class="TDTitulo">';
            tabela += '         Usuário';
            tabela += '     </td>';
            tabela += '     <td width="14%" class="TDTitulo">';
            tabela += '         Data da Operação';
            tabela += '     </td>';
            tabela += '     <td width="12%" class="TDTitulo">';
            tabela += '         Tipo de Operação';
            tabela += '     </td>';
            tabela += ' </tr>';
            registro = data[1];
            for(var i=0;i<registro.length;i++){
                if ( corLinha === "white" ){
                    corLinha="E8E8E8";
                }else{
                    corLinha="white";
                }
            tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
            tabela += '    <td>'+registro[i].COD_OPERACAO+'</td>';
            tabela += '    <td>'+registro[i].COD_VENDA+'</td>';
            tabela += '    <td>'+registro[i].DSC_PRODUTO+'</td>';
            tabela += '    <td>'+registro[i].QTD_PRODUTO+'</td>';
            tabela += '    <td>R$ '+registro[i].VLR_PRODUTO+'</td>';
            tabela += '    <td>'+registro[i].COD_USUARIO+'</td>';
            tabela += '    <td>'+registro[i].DTA_OPERACAO+'</td>';
            tabela += '    <td align="right">'+registro[i].TPO_OPERACAO+'</td>';
            tabela += ' </tr>';
            }
            tabela += '  </table>';
        tabela += '</td>';    
    tabela += '</tr>';
    }
    if (data[2]!=null){
    tabela += '<tr>';
        tabela += '<td>';
            tabela += '<table align="center" width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
            tabela += '<tr>';
            tabela += '<td colspan="8" align="center" class="TDTituloCabecalho"> Log de Pagamentos </td>';
            tabela += '</tr>';
            tabela += '<tr>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Número da Operação';
            tabela += '     </td>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Cod. Venda';
            tabela += '     </td>';
            tabela += '     <td width="12%" class="TDTitulo">';
            tabela += '         Cod. Pagamento';
            tabela += '     </td>';
            tabela += '     <td width="12%" class="TDTitulo">';
            tabela += '         Forma de Pagamento';
            tabela += '     </td>';
            tabela += '     <td width="15%" class="TDTitulo">';
            tabela += '         Valor do Pagamento';
            tabela += '     </td>';
            tabela += '     <td width="17%" class="TDTitulo">';
            tabela += '         Usuário';
            tabela += '     </td>';
            tabela += '     <td width="14%" class="TDTitulo">';
            tabela += '         Data da Operação';
            tabela += '     </td>';
            tabela += '     <td width="13%" class="TDTitulo">';
            tabela += '         Tipo de Operação';
            tabela += '     </td>';
            tabela += ' </tr>';
            registro = data[2];
            for(var i=0;i<registro.length;i++){
                if ( corLinha === "white" ){
                    corLinha="E8E8E8";
                }else{
                    corLinha="white";
                }
            tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
            tabela += '    <td>'+registro[i].COD_OPERACAO+'</td>';
            tabela += '    <td>'+registro[i].COD_VENDA+'</td>';
            tabela += '    <td>'+registro[i].COD_PAGAMENTO+'</td>';
            tabela += '    <td>'+registro[i].DSC_TIPO_PAGAMENTO+'</td>';
            tabela += '    <td>R$ '+registro[i].VLR_PAGAMENTO+'</td>';
            tabela += '    <td>'+registro[i].COD_USUARIO+'</td>';
            tabela += '    <td>'+registro[i].DTA_OPERACAO+'</td>';
            tabela += '    <td align="right">'+registro[i].TPO_OPERACAO+'</td>';
            tabela += ' </tr>';
            }
            tabela += '  </table>';
        tabela += '</td>';
    tabela += '</tr>';
    }
    $("#Registros").html(tabela);
}