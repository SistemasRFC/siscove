function CarregaGridPagamentos(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/AdiantarRecebimentos/AdiantarRecebimentosController.php',
        {
            method: 'ListarAdiantarRecebimentos',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val()
        },function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaPagamentos(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaPagamentos(listaPagamentos){
    valorTotal = 0;
    bgColor = 'white';
    var tabela = "<table cellpadding='0' cellspacing='0' width='50%' border=0>";
    tabela += "<tr>";
    tabela += "<td width='10%'>Venda</td>";
    tabela += "<td width='10%'>Data da Venda</td>";
    tabela += "<td width='10%'>Data do Pagamento</td>";
    tabela += "<td width='20%'>Forma</td>";
    tabela += "<td width='20%' style='text-align:right;'>Valor</td>";
    tabela += "<td width='40%' style='text-align:right;'>Valor Pago</td>";
    tabela += "</tr>";
    for (i=0;i<listaPagamentos.length;i++){
        if (bgColor=='white'){
            bgColor='#D5D5D5';
        }else{
            bgColor='white';
        }
        tabela += "<tr bgcolor='"+bgColor+"'>";
        tabela += "<td>"+listaPagamentos[i].COD_VENDA+"</td>";
        tabela += "<td>"+listaPagamentos[i].DTA_VENDA+"</td>";
        tabela += "<td>"+listaPagamentos[i].DTA_PAGAMENTO+"</td>";
        tabela += "<td>"+listaPagamentos[i].DSC_TIPO_PAGAMENTO+"</td>";
        tabela += "<td style='text-align:right;'>"+listaPagamentos[i].VLR_PAGAMENTO+"</td>";
        tabela += "<td style='text-align:right;'><input type='text' id='txt"+listaPagamentos[i].NRO_SEQUENCIAL+"' nroSequencial='"+listaPagamentos[i].NRO_SEQUENCIAL+"' class='vlrPago'></td>";
        tabela += "</tr>";
//        console.log(valor);
        valor = listaPagamentos[i].VLR_PAGAMENTO;
        valor = valor.replace('.',''); 
        valor = valor.replace(',','.');     
        console.log(valor);
        valorTotal = parseFloat(valorTotal)+parseFloat(valor);
        console.log(valorTotal);
    }
    tabela += "<tr bgcolor='"+bgColor+"'>";
    tabela += "<td colspan='5' style='text-align:right'>Total: "+Formata(valorTotal,2,'.',',')+"</td>";
    tabela += "</tr>";    
    tabela += '</table>';
    $("#ListagemForm").html(tabela);
    $(".vlrPago").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
}

function SalvarValores(){
    nroSequencial = LerInputs();    
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/AdiantarRecebimentos/AdiantarRecebimentosController.php',
        {
            method: 'AddAdiantarRecebimentos',
            nroSequencial: nroSequencial
            
        },function(data){

            data = eval('('+data+')');
            if (data[0]){
                CarregaGridPagamentos();         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });    
}
function LerInputs(){
    var nroSequencial = '';    
    $(".vlrPago").each(function() {
        var codigo = $(this).attr("nroSequencial");  
        vlrPagamento = $(this).val();
        if (parseInt(vlrPagamento)>0){
            nroSequencial = nroSequencial+codigo+';'+$(this).val()+"|";
        }        
    });    
    return nroSequencial;    
}