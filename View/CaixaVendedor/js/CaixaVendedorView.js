var impressao;
$(function() {
    $(".FechamentoCaixa").hide();    
    $( "#dtaPagamento" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $("#ListaCaixasFechadosForm").jqxWindow({ 
        title: 'Lista de Caixas Fechados',
        height: 500,
        width: 700,
        maxWidth: 1200,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });      
    $("#btnFechamento").click(function(){
        FecharCaixa();
    });     
    $("#btnCaixasFechados").click(function(){
        CarregaListaCaixasFechados();
    });    
    $("#btnPesquisar").click(function(){
        CarregaPagamentosVendedor(); 
    });
});

function CarregaPagamentosVendedor(){
    $("#tabelaPagamentos").html('');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/CaixaVendedor/CaixaVendedorController.php',{
        method: 'ListarPagamentosVendedor',
        dtaPagamento: $("#dtaPagamento").val()
    },function(data){
        data = eval('('+data+')');
        if (data[0]){
            if (data[1]!=null){
                var pagamentosVendedor = data[1];
                var pagamentosTipo = data[2];            
                MontaTabelaPagamentosVendedor(pagamentosVendedor, pagamentosTipo);         
                $( "#dialogInformacao" ).jqxWindow("close");      
                $("#btnFechamento").show();
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Sem registros para fechamento do caixa");
                $(".FechamentoCaixa").hide();
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow("close");        
                },3000);
            }
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
        }
    });    
}

function MontaTabelaPagamentosVendedor(pagamentosVendedor, pagamentosTipo){
    impressao = '<html><head><link rel="stylesheet" href="../../Resources/css/style.css?random=<?php echo time();?>" type="text/css" /></head>';
    impressao += '<table align="center" width="100%">';
    impressao += '<tr><td align="center"><span style="font-size: 20;">Fechamento de caixa do Vendedor '+pagamentosVendedor[0].NME_USUARIO_COMPLETO+'</span></td></tr>';
    impressao += '<tr><td align="center"><span style="font-size: 20;">Data do Fechamento: #data#</span></td></tr>';
    impressao += '<tr><td>';
    var tabela = '<table width="100%" class="TabelaCabecalho" cellpading="0" cellspacing="0">';
    tabela += '<tr>';
    tabela += '<td class="TDTitulo">Código da Venda</td>';
    tabela += '<td class="TDTitulo">Status da Venda</td>';
    tabela += '<td class="TDTitulo">Tipo de Pagamento</td>';
    tabela += '<td class="TDTitulo" align="right">Valor do Pagamento</td>';
    tabela += '</tr>';
    bgColor = 'white';
    for(i=0; i<pagamentosVendedor.length; i++){
        if (bgColor=='white'){
            bgColor='#D5D5D5';
        }else{
            bgColor='white';
        }
        tabela += '<tr class="trcor" bgcolor="'+bgColor+'">';
        tabela += '<td>'+pagamentosVendedor[i].COD_VENDA+'</td>';
        tabela += '<td>'+pagamentosVendedor[i].DSC_STATUS_VENDA+'</td>';
        tabela += '<td>'+pagamentosVendedor[i].DSC_TIPO_PAGAMENTO+'</td>';
        tabela += '<td align="right">'+pagamentosVendedor[i].VLR_PAGAMENTO+'</td>';
        tabela += '</tr>';        
    }
    tabela += '</table>';
    impressao += tabela;
    impressao += '</td></tr>';   
    $("#tabelaPagamentosVendedor").html(tabela);
    
    bgColor = '#D5D5D5';
    impressao += '<tr><td align="center"><span style="font-size: 20;"><br>Resumo do Fechamento de caixa</span></td></tr>';
    impressao += '<tr><td>';
    var tabela = '<table width="50%" align="center" class="TabelaCabecalho" cellpading="0" cellspacing="0">';
    tabela += '<tr>';
    tabela += '<td class="TDTitulo">Tipo de Pagamento</td>';
    tabela += '<td class="TDTitulo" align="right">Valor do Pagamento</td>';
    tabela += '</tr>';
    for(i=0; i<pagamentosTipo.length; i++){
        tabela += '<tr class="trcor" bgcolor="'+bgColor+'">';
        tabela += '<td>'+pagamentosTipo[i].DSC_TIPO_PAGAMENTO+'</td>';
        tabela += '<td align="right">'+pagamentosTipo[i].VLR_PAGAMENTO+'</td>';
        tabela += '</tr>';     
        if (bgColor=='white'){
            bgColor='#D5D5D5';
        }else{
            bgColor='white';
        }        
    }
    tabela += '<tr class="trcor" bgcolor="'+bgColor+'">';
    tabela += '<td class="TDTitulo">Total</td>';
    tabela += '<td class="TDTitulo" align="right">'+pagamentosTipo[0].VLR_TOTAL+'</td>';
    tabela += '</tr>';     
    tabela += '</table>';
    impressao += tabela;
    impressao += '</td></tr>';    
    impressao += '<tr><td align="center"><input type="button" value="Imprimir" onclick="javascript:window.print();"></td></tr></table></html>';
    $("#tabelaPagamentosTipo").html(tabela); 
    $(".FechamentoCaixa").show();
}

function FecharCaixa(){
    $("#tabelaPagamentos").html('');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/CaixaVendedor/CaixaVendedorController.php',{
        method: 'FecharCaixaVendedor',
        dtaPagamento: $("#dtaPagamento").val()
    },function(data){
        data = eval('('+data+')');
        if (data[0]){
            impressao = impressao.replace("#data#", data[1][0].DTA_CAIXA);          
            PreparaImpresao();      
            CarregaListaCaixasFechados();
            $("#tabelaPagamentosVendedor").html('');
            $("#tabelaPagamentosTipo").html('');   
            $("#btnFechamento").hide();
            $( "#dialogInformacao" ).jqxWindow("close");      
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
        }
    });       
}

function PreparaImpresao(){
    
    wLeft = window.screenLeft ? window.screenLeft : window.screenX;
    wTop = window.screenTop ? window.screenTop : window.screenY;
    var w = 1000;
    var h = 500;
    var left = wLeft + (window.innerWidth / 2) - (w / 2);
    var top = wTop + (window.innerHeight / 2) - (h / 2);    
    var tmpSinteticoPagamentoColaborador = window.open('', 'Fechamento de caixa', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left + ', screenX=' + left + ', screenY=' + top);
    tmpSinteticoPagamentoColaborador.document.body.innerHTML='';
    tmpSinteticoPagamentoColaborador.document.write(impressao);
    tmpSinteticoPagamentoColaborador.focus();     
}