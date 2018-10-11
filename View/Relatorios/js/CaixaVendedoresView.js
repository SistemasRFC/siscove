$(function() {
    $("input[type='button']").jqxButton({theme: theme});
    $( "#dtaCaixa" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $("#btnPesquisa").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
          $( "#dialogInformacao" ).jqxWindow("open"); 
            if ($("#dtaCaixa").val()==''){
                $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma data!');
                $("#dtaCaixa").focus();
                exit;
            }            
            if (($("#codFuncionario").val()=='0')||
                ($("#codFuncionario").val()==null)){
                $( "#dialogInformacao" ).jqxWindow('setContent','Selecione um funcionário!');
                $("#codFuncionario").focus();
                exit;
            }
            
//        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosFluxoCaixaController.php', {
            method: 'CaixaVendedor',
            dtaCaixa: $("#dtaCaixa").val(),
            codFuncionario: $("#codFuncionario").val()
        }, function(data){
            data = eval('('+data+')');
            
            if (data[1]!==null){
                carregaTabela(data[1]);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro ao efetuar consulta!");
                $( "#dialogInformacao" ).jqxWindow("open");  
            }
        });
    });
     CriarCombo('codFuncionario', 
               '../../Controller/Funcionario/FuncionarioController.php', 
               'method;ListarVendedoresAtivos', 
               'COD_FUNCIONARIO|NME_FUNCIONARIO', 
               'NME_FUNCIONARIO', 
               'COD_FUNCIONARIO');
});

//function java(dochtml) {
//var left=(window.screen.width/2)-(1000/2);
//var top = ((window.screen.height/2)-50)-(700/2);
//	if(navigator.appName == "Netscape") {
//		var sec = window.open(dochtml,'','scrollbars=yes,toolbars=no,status=no,menubar=no,resizable=yes,height=700,width=1000,top='+top+',left='+left);
//		sec.focus();
//	}
//	else {
//		var new_window = window.open(dochtml,'','resizable=yes,width=1000,height=700, left='+ left +', top='+ top +',toolbars=no,menubar=no,status=no,scrollbars=1');
//		new_window.focus;
//	}
//}

function carregaTabela(data){
    codVenda=0;
    linha = '<link href="../../Resources/css/style.css" rel="stylesheet">';
    linha += '<table width="100%" class="TabelaConteudo" style="border: 1px solid #000000;">';
    linha += '<tr>';
    linha += '<td colspan="3" align="center"><font size=5 ><b> Pagamentos do dia </b></font></td>';
    linha += '</tr>';
    total = data.length;
    corLinha = 'white';
    primeira = true;
    
    for(var i=0;i<total;i++){
        if (corLinha == 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }
        if (codVenda!=data[i].COD_VENDA){
            linha += '<tr bgcolor="'+corLinha+'">';
            linha += '<td colspan="3" style="border: 1px solid #000000;">';
            linha += '<b>Código da Venda: </b>'+data[i].COD_VENDA+'<br>\n\ ';
            linha += '<b>Data da Venda: </b>'+data[i].DTA_VENDA+'<br>\n\ ';
            linha += '<b>Cliente: </b>'+data[i].DSC_CLIENTE+'<br>\n\ ';
            linha += '<b>Vendedor: </b>'+data[i].NME_VENDEDOR+'<br>\n\ ';
            linha += '</td>';
            linha += '</tr>';
            linha += '<tr>';
            linha += '<td><b>Data do pagamento: </td>';
            linha += '<td><b>Forma de pagamento: </td>';             
            linha += '<td><b>Valor: </td>';
            linha += '</tr>';
        }
    
        linha += '<tr class="trcor">';
        linha += '<td>'+data[i].DTA_PAGAMENTO+'</td>';
        linha += '<td>'+data[i].DSC_TIPO_PAGAMENTO+'</td>';
        linha += '<td>'+data[i].VLR_PAGAMENTO+'</td>';
        linha += '</tr>';
    
        codVenda = data[i].COD_VENDA;
    }
    linha += '<tr>';
    linha += '<td align="right" colspan="3"><b>Total: '+data[0].VLR_TOTAL+'</td>';
    linha += '</tr>';
    linha += '</table>';
     
    wLeft = window.screenLeft ? window.screenLeft : window.screenX;
    wTop = window.screenTop ? window.screenTop : window.screenY;
    var w = 1000;
    var h = 500;
    var left = wLeft + (window.innerWidth / 2) - (w / 2);
    var top = wTop + (window.innerHeight / 2) - (h / 2);    
    var tmpSinteticoPagamentoColaborador = window.open('', 'Relatório de pagamentos do dia', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left + ', screenX=' + left + ', screenY=' + top);
    tmpSinteticoPagamentoColaborador.document.body.innerHTML='';
    tmpSinteticoPagamentoColaborador.document.write(linha);
    tmpSinteticoPagamentoColaborador.focus();
    $(tmpSinteticoPagamentoColaborador).blur(function(){
       //tmpSinteticoPagamentoColaborador.close();
    });
    $( "#dialogInformacao" ).jqxWindow("close");  
    //console.log(tmpSinteticoPagamentoColaborador.top);
}