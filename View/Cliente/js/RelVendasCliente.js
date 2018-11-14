function VendasCliente(){        
    $.post('../../Controller/Cliente/ClienteController.php',
    {
        method:'ListarVendasPorCliente',
        codClienteVenda: $("#codCliente").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaVendas(data[1], data[3]);
        }
    });    
}

function MontaTabelaVendas(Lista, vlrTotal){ 
    var trCor = 'gray';
    var table = '<table cellpadding=1 cellspacing=0 width="100%">';
    table += '<tr>';
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Codigo da Venda</td>';
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Data da Venda</td>';
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Produto</td>';        
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Valor da Venda</td>';
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Desconto da Venda</td>';
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Quantidade da Venda</td>';
    table += '<td style="text-align:center; font-size:11px; border:1px solid #000;">Total</td>';
    table += '</tr>';
    for (i=0;i<Lista.length;i++){
        table += '<tr bgcolor="'+trCor+'">';
        table += '<td style="text-align:right; font-size:11px;">'+Lista[i].COD_VENDA+'</td>';
        table += '<td style="text-align:right; font-size:11px;">'+Lista[i].DTA_VENDA+'</td>';
        table += '<td style="text-align:left; font-size:11px;">'+Lista[i].DSC_PRODUTO+'</td>';        
        table += '<td style="text-align:right; font-size:11px;">'+Lista[i].VLR_VENDA_UNITARIA+'</td>';
        table += '<td style="text-align:right; font-size:11px;">'+Lista[i].VLR_DESCONTO+'</td>';
        table += '<td style="text-align:right; font-size:11px;">'+Lista[i].QTD_VENDIDA+'</td>';
        table += '<td style="text-align:right; font-size:11px;">'+Lista[i].VLR_VENDA+'</td>';
        table += '</tr>'; 
        if (trCor=='white'){
            trCor='gray';
        }else{
            trCor = 'white';
        }        
    }    
    table += '<tr bgcolor="'+trCor+'">';
    table += '<td style="text-align:right; font-size:11px;" colspan="7">Total: '+vlrTotal+'</td>';
    table += '</tr>';     
    table += '</table>';
    $("#Rel").html(table);
}
$(document).ready(function(){
    VendasCliente();
});