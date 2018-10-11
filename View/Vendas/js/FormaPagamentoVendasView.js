$(function() {
    $( "#dtaPagamento" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme});
    $("#btnSalvarPagamento").click(function(){
        if ($("#dtaPagamento").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Selecione uma data de pagamento!");
            return false;            
        }        
        if ($("#codTipoPagamento").val()==3){
            vlrParcela = parseFloat($("#vlrPagamento").val())/parseFloat($("#qtdParcelas").val());
        }else{
            vlrParcela = parseFloat($("#vlrPagamento").val());
        }
        
        $.post('../../Controller/Vendas/FormaPagamentoVendasController.php',
              {method:'InserirPagamento',
               codVenda: $("#codVenda").val(),
               codTipoPagamento: $("#codTipoPagamento").val(),
               vlrPagamento: vlrParcela,
               dtaPagamento: $("#dtaPagamento").val(),
               nroCheque: $("#nroCheque").val(),
               nroBanco: $("#nroBanco").val(),
               nmeProprietario: $("#nmeProprietario").val(),
               dscMercadoria: $("#dscMercadoria").val(),
               codProdutoEstoque: $("#codProdutoEstoque").val(),
               qtdParcelas: $("#qtdParcelas").val(),
               qtdMercadoria: $("#qtdMercadoria").val(),
               nroStatusVenda: $("#nroStatusVenda").val()},function(data){

               data = eval('('+data+')');
               if (data[0]){
                   CarregaTabelaPagamentos();
                   $("#dtaPagamento").val('');
                   $("#vlrPagamento").val('0');
                   $("#nroCheque").val('');
                   $("#codTipoPagamento").jqxDropDownList('selectIndex', -1);
                   $("#codTipoPagamento").change();
                   $("#nroBanco").val('');
                   $("#nmeProprietario").val('');
                   $("#codProdutoEstoque").val('');
                   $("#dscMercadoriaVenda").val('');
                   $("#qtdMercadoria").val('');
                   $("#qtdParcelas").val('');
                   atualizaTipoPagamento(codTipoPagamento);
               }else{
                   $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao inserir pagamento!'+data[1]);
                   $( "#dialogInformacao" ).jqxWindow("open");                                       
               }
        });
    });
    $("#btnFecharVenda").click(function(){
        if ($("#indAbaixo").val()=="1"){
            $( "#dialogJustificativa" ).jqxWindow( "open" );                    
        }else{
            valorMenor = parseFloat($("#vlrTotalVenda").html().replace(',',''))+parseFloat(0.01);
            valorMaior = parseFloat($("#vlrTotalVenda").html().replace(',',''))-parseFloat(0.01);
            vlrTotalVenda = $("#vlrTotalVenda").html().replace(',','');
            vlrVenda = $("#lblvlrTotalVenda").html().replace(',','');
            if ((vlrTotalVenda!=vlrVenda)&&
                (valorMenor!=vlrVenda)&&
                (valorMaior!=vlrVenda)){
                msg = 'Valores da venda e somatória dos pagamentos divergentes!';
                
                if ($("#codPerfil").val()!='3' && $("#codPerfil").val()!='4' ){
                    msg += '<input type="button" value="Fechar mesmo assim?" onclick="javascript:EmitirNotaFiscal();">';
                }
                $( "#dialogInformacao" ).jqxWindow('setContent', msg);
                $( "#dialogInformacao" ).jqxWindow( "open" );
                //return false;
            }else{
                EmitirNotaFiscal(); 
            }
        }
    });
    $("#btnResumoVenda").click(function(){
        window.open('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda='+$("#codVenda").val()+'&method=ResumoVenda','page','left=100,top=50,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=500');
    });
    $("#btnResumoServicos").click(function(){
        window.open('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda='+$("#codVenda").val()+'&method=ResumoServicos','page','left=100,top=50,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=500');
    });
    $("#btnJustificarPagamento").click(function(){
        $("#dialogJustificativa").jqxWindow("open");
    });
    $("#btnJustificar").click(function(){
        jus = $("#txtJustificativa").val();
        if (jus.trim()==''){
            $( "#dialogInformacao" ).html('Digite uma justificativa por favor!');
            $( "#dialogInformacao" ).dialog( "open" );
            return false;
        }else{
            FecharVenda();
        }
        //$("#btnFecharVenda").click();
    });    
    $('#codTipoPagamento').change(function() {
        atualizaTipoPagamento($(this).val());
    });
    $("#codTipoPagamento").focus();

    $("#dscMercadoriaVenda").keyup(function(key){
        if ((key.keyCode!=40) && (key.keyCode!=38)){
            if ($(this).val().trim()!=''){
                CriarDivAutoComplete($(this).attr('id'), 
                                     "../../Controller/Produto/ProdutoController.php", 
                                     'ListarProdutosAutoComplete',
                                     ";id|codProdutoEstoque;COD_PRODUTO|dscMercadoriaVenda;DSC_PRODUTO|;value|", 
                                     "value", 
                                     "id",
                                     null);            
            }else{
                if ( $("#divAutoComplete").length ){
                    $("#divAutoComplete").jqxWindow("destroy");
                }
            }
        }else{
            $("#listaPesquisa").jqxListBox('selectedIndex' ,0);
            $("#listaPesquisa").jqxListBox("focus");
        }
    });
    $("#dscMercadoriaVenda").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });    
});

function EmitirNotaFiscal(){
	$( "#dialogInformacao" ).jqxWindow('setContent', 'Deseja emitir Nota?<br>\n\
                                                          <input type="button" value="Sim" onclick="javascript:FecharVenda(\'S\');">\n\
							  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n\
							  <input type="button" value="Não" onclick="javascript:FecharVenda(\'N\');">');	
	$( "#dialogInformacao" ).jqxWindow("open"); 													  
}
function atualizaTipoPagamento(codTipoPagamento){
    if (codTipoPagamento==3){
        $("#cartaoCredito").css("border", "1px solid #990000");
        $("#mercadoria").hide('slow');
        $("#cheques").hide('slow');
        $("#cartaoCredito").show('slow');
    }else if (codTipoPagamento==4){
        $("#cheques").css("border", "1px solid #990000");
        $("#mercadoria").hide('slow');
        $("#cartaoCredito").hide('slow');
        $("#cheques").show('slow');
    }else if (codTipoPagamento==5){
        $("#mercadoria").css("border", "1px solid #990000");
        $("#cheques").hide('slow');
        $("#cartaoCredito").hide('slow');
        $("#mercadoria").show('slow');

        $("#bntDscMercadoria").click(function(){
            $("#codProduto").val("");
            $("#dscProduto").val("");           
            $("#codTipoProduto").val("");          
            $("#codMarca").val("");
            $("#vlrVenda").val("0");
            $("#vlrMinimo").val("0");
            $("#nroAroPneu").val("0");        
            $("#indAtivo").jqxCheckBox('uncheck');           
            $("#CadastroProdutoForm").jqxWindow("open");
        });
        $( "#btnSalvarProduto" ).click(function( event ) {
            SalvarProduto();
        });
    }else{
        $("#cheques").hide('slow');
        $("#mercadoria").hide('slow');
        $("#cartaoCredito").hide('slow');
    }    
}