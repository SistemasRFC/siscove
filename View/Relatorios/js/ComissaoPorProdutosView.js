$(function() {
    $("input[type='button']").jqxButton({theme: theme}); 
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        MoveProdutosSelecionados();
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open"); 
        if ($("#dtaVendaInicio").val()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma data inicial!');
            $("#dtaVendaInicio").focus();
            exit;
        }
        if ($("#dtaVendaFim").val()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma data final!');
            $("#dtaVendaFim").focus();
            exit;
        }
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/ComissaoPorProdutosController.php', { 
            method: 'DadosComissao',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val(),
            codProduto: $("#codProdutosSelecionados").val()}, function(data){
            data = eval('('+data+')');

            if (data[0]){
                if (data[1]!=null){
                    MontaTabelaComissao(data);
                    $( "#dialogInformacao" ).jqxWindow('close');
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent','Sem Dados para a pesquisa!');
                }
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao efetuar pesquisa!');
            }
        });
    });
    $("#btnSeleciona").click(function(){
        MoveProdutosSelecionados();
    });
    $("#btnLimparSelecao").click(function(){
        $("#listaProdutos").jqxListBox('uncheckAll'); 
        $("#listaProdutosSelecionados").jqxListBox('clear'); 
        $("#codProdutosSelecionados").val('');
    });
});
function MoveProdutosSelecionados(){
    var items = $("#listaProdutos").jqxListBox('getCheckedItems');
    var codigos = '';
    $("#listaProdutosSelecionados").jqxListBox({  
        width: 400, 
        multiple: true,
        height: 250
    });    
    $("#listaProdutosSelecionados").jqxListBox('clear');
    for(i=0;i<items.length;i++){
        codigos = codigos+items[i].originalItem.COD_PRODUTO+', ';
        $("#listaProdutosSelecionados").jqxListBox('insertAt', items[i].originalItem.DSC_PRODUTO, 1 ); 
    }
    codigos = codigos.substring(0, codigos.length-2);
    $("#codProdutosSelecionados").val(codigos);
}
function MontaTabelaComissao(data){
    codVenda=0;
    $("#conteudo").html('');
    linha = '<table width="60%" align="center" class="TabelaConteudo" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;">';
    vlrTotal = 0;
    corLinha = 'white';
    primeira = true;
    linha = linha+
        ' <tr>'+
    ' <tr>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Venda\n\ '+
    '     </td>\n\ '+     
    '     <td class="TDTitulo">\n\ '+
    '         Data da Venda\n\ '+
    '     </td>\n\ '+          
    '     <td class="TDTitulo">\n\ '+
    '         Produto\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Valor\n\ '+
    '     </td>\n\ '+
    ' </tr>\n\ ';    
    for(var i=0;i<data[1].length;i++){
        if (corLinha == 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }        
        codVenda = data[1][i].COD_VENDA;
        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[1][i].COD_VENDA+'</td>'+
            ' <td>'+data[1][i].DTA_VENDA+'</td>'+
            ' <td id="dtaVenda">'+data[1][i].DSC_PRODUTO+'</td>'+
            ' <td id="dscCliente" align="right">'+data[1][i].VLR_VENDA_TOTAL+'</td>'+
        ' </tr>';
        vlrTotal = parseFloat(vlrTotal)+parseFloat(data[1][i].VLR_VENDA_TOTAL);
    }
    linha = linha + ' <tr> '+
            ' <td colspan="4" align="right" class="TDTitulo">Total: '+Formata(vlrTotal,2,',','.')+'</td>'+
            ' </tr>'+
    ' </table>';
    wLeft = window.screenLeft ? window.screenLeft : window.screenX;
    wTop = window.screenTop ? window.screenTop : window.screenY;
    var w = 700;
    var h = 400;
    var left = wLeft + (window.innerWidth / 2) - (w / 2);
    var top = wTop + (window.innerHeight / 2) - (h / 2);    
    var tmp = window.open('', 'Relatório de comissão de produtos', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left + ', screenX=' + left + ', screenY=' + top);
  //window.open('', 'popimpr');
    tmp.document.write('Relatório de comissão de produtos');
    tmp.document.write(linha);
    //tmp.window.print();
    //tmp.window.close();            
    //$("#conteudo").html(linha);    
}

function ListarProdutos(){
    $.post('../../Controller/Produto/ProdutoController.php', { 
        method: 'ListarProdutosAtivos'
    }, function(data){
        data = eval('('+data+')');

        if (data[0]){
            if (data[1]!=null){
                MontaListaProdutos(data[1]);
                $( "#dialogInformacao" ).jqxWindow('close');
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Sem Dados para a pesquisa!');
            }
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao efetuar pesquisa!');
        }
    });
}

function MontaListaProdutos(lista){
    
    // prepare the data
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'DSC_PRODUTO' },
            { name: 'COD_PRODUTO' }
        ],
        id: 'COD_PRODUTO',
        localdata: lista
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxListBox
    $("#listaProdutos").jqxListBox({ 
        source: dataAdapter, 
        displayMember: "DSC_PRODUTO", 
        valueMember: "DSC_PRODUTO", 
        width: 400, 
        multiple: true,
        checkboxes:true,
        height: 250
    });    
}
$(document).ready(function(){
    ListarProdutos();
});
