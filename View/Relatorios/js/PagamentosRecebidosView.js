$(function() {
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosVendasController.php', {
            method: 'PagamentosRecebidos',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val(),
            codTipoPagamento: $("#codTipoPagamento").val()
        }, function(data){
            data = eval('('+data+')');

            if (data[0]){
                if (data[1]!=null){
                    carregaTabela(data[1]);
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setcontent','Sem dados para este pesquisa!');
                    $( "#dialogInformacao" ).jqxWindow( "show" );
                }
            }else{
                $( "#dialogInformacao" ).jqxWindow('setcontent','Erro ao efetuar consulta!');
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });    
});

function carregaTabela(data){
    codVenda=0;
    vlrTotalVenda =0;
    $("#conteudo").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2"  style="border: 1px solid #000000;">';
    corLinha = 'white';
    primeira = true;
    linha = linha+'<tr>'+
                ' <td class="TDTitulo"> Código da Venda </td>\n\ '+
                ' <td class="TDTitulo"> Data Do Recebimento </td>\n\ '+
                ' <td class="TDTitulo"> Tipo de Pagamento </td>\n\ '+ 
                ' <td align="right" class="TDTitulo"> Valor </td>\n\ '+
                '</tr>';
    for(var i=0;i<data.length-1;i++){
            if (corLinha === 'white'){
                corLinha = '#E8E8E8';
            }else{
                corLinha = 'white';
            }

        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[i].COD_VENDA+'</td>'+
            ' <td>'+data[i].DTA_PAGAMENTO+'</td>'+
            ' <td>'+data[i].DSC_TIPO_PAGAMENTO+'</td>'+
            ' <td align="right">'+data[i].VLR_PAGAMENTO+'</td>'+
            " <td align='right'><a href=\"javascript:java('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda="+data[i].COD_VENDA+"&method=ResumoVenda');\">"+
            "<img src=\"../../Resources/images/import.png\" width=\"20\" height=\"20\" title=\"Visualizar esta venda\"></a></td>"+
        ' </tr>';
    }
    linha +='<tr><td align="right" colspan="5">Total das Vendas: R$ '+data[data.length-1].VLR_TOTAL+'</td></tr>'+
            '</table>';
    $("#conteudo").html(linha);
}
function ReabrirVenda(codVenda){    
    $("#btnOK").hide();    
    $.post('../../Controller/Vendas/VendasController.php',
          {method:'ReabrirVenda',
           codVenda: codVenda}, function(data){

                if(data==1){
                    $("#btnPesquisa").click();
                    $( "#dialogInformacao" ).html('Venda reaberta com sucesso!');
                    $("#btnOK").show();
                }else{
                    $( "#dialogInformacao" ).html('Erro ao reabrir venda!');
                    $("#btnOK").show();
                }
           }
    );
}
function java(dochtml) {
var left=(window.screen.width/2)-(1000/2);
var top = ((window.screen.height/2)-50)-(700/2);
	if(navigator.appName == "Netscape") {
		var sec = window.open(dochtml,'','scrollbars=yes,toolbars=no,status=no,menubar=no,resizable=yes,height=700,width=1000,top='+top+',left='+left);
		sec.focus();
	}
	else {
		var new_window = window.open(dochtml,'','resizable=yes,width=1000,height=700, left='+ left +', top='+ top +',toolbars=no,menubar=no,status=no,scrollbars=1');
		new_window.focus;
	}
}
$(document).ready(function(){
    CarregaTipoPagamento();
});

function CarregaTipoPagamento(){
    $.post('../../Controller/TipoPagamento/TipoPagamentoController.php',
        {
            method:'ListarTipoPagamentoAtivo'
        }, 
        function(data){
            data = eval('('+data+')');
            if(data[0]){
                MontaComboTipoPagamento(data[1]);
            }
        }
    );    
}

function MontaComboTipoPagamento(data){
    var nmeCombo = 'codTipoPagamento';
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields:
        [
            { name: 'COD_TIPO_PAGAMENTO', type: 'int' },
            { name: 'DSC_TIPO_PAGAMENTO', type: 'string' }
        ],
        cache: false,
        localdata: data
    };       
    var dataAdapter = new $.jqx.dataAdapter(source,{
        loadComplete: function (records){         
            $("#"+nmeCombo).jqxDropDownList(
            {
                source: records,
                theme: theme,
                width: 200,
                height: 25,
                selectedIndex: 0,
                displayMember: 'DSC_TIPO_PAGAMENTO',
                valueMember: 'COD_TIPO_PAGAMENTO'
            }); 
            
        },
        async:true
    });  
    dataAdapter.dataBind();        
    $("#"+nmeCombo).jqxDropDownList('insertAt', 'Todos', 0 );
    $("#"+nmeCombo).jqxDropDownList('selectItem', 0 );
}