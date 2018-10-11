$(function() {
    $( "#dtaInicioNfe" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaFimNfe" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisaNfe").click(function(){
        $("#listaNotas").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosNfeController.php', {
            method: 'ListarNotasEmitidas',
            dtaInicioNfe: $("#dtaInicioNfe").val(),
            dtaFimNfe: $("#dtaFimNfe").val()}, function(data){
            data = eval('('+data+')');

            if (data!=null){
                carregaTabela(data[1], data[3]);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Sem dados para essa consulta!');
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });    
});

function carregaTabela(data, vlrTotal){
    $("#listaNotas").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0"  style="border: 1px solid #000000;">';
    total = data.length;
    corLinha = 'white';
    primeira = true;
    linha = linha+'<tr>'+
                '<td><table width="100%">\n\ '+
                ' <tr><td class="TDTitulo">Código da Venda </td>\n\ '+
                ' <td class="TDTitulo">Código de Referência </td>\n\ '+
                ' <td class="TDTitulo">CPF </td>\n\ '+
                ' <td class="TDTitulo">Cliente </td>\n\ '+
                ' <td class="TDTitulo">Data da Venda </td>\n\ '+
                ' <td class="TDTitulo">Data da Emissão da NFE</td>\n\ '+
                ' <td class="TDTitulo">Valor da Venda </td>\n\ '+
                ' </tr>';
    for(var i=0;i<total;i++){
            if (corLinha == 'white'){
                corLinha = '#E8E8E8';
            }else{
                corLinha = 'white';
            }

        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[i].COD_VENDA+'</td>'+
            ' <td>'+data[i].COD_REFERENCIA+'</td>'+
            ' <td>'+data[i].CPF_CLIENTE+'</td>'+
            ' <td>'+data[i].DSC_CLIENTE+'</td>'+
            ' <td>'+data[i].DTA_VENDA+'</td>'+
            ' <td>'+data[i].DTA_EMISSAO+'</td>'+
            ' <td align="right">R$ '+data[i].VLR_TOTAL_VENDA+'</td>'+
        ' </tr>';
    }
    linha += "<tr><td align='right' colspan='7'><b>Total:</b> R$ "+vlrTotal+"</td></tr>";
    linha += "</table>";
    $("#listaNotas").html(linha);
}