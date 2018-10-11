<table width="100%" id="resultado">
    <tr bgcolor="#fdf5ce" style=>
        <td>Data</td>
        <td>Tipo</td>
        <td>Valor</td>
        <td>&nbsp;</td>
    </tr>
<?php
if (isset($_POST['listaPagamentoVendas'])){
    $rs_pagamento = unserialize(urldecode($_POST['listaPagamentoVendas']));
    $total = count($rs_pagamento);
    $i=0;
    $vlrTotal = 0;
    while($i<$total ) {
        if ($rs_pagamento[$i]['COD_TIPO_PAGAMENTO']==4){
            echo"<tr id=\"".$i."\" 
                title=\"N. Cheque: ".$rs_pagamento[$i]['NRO_CHEQUE']." Banco: ".$rs_pagamento[$i]['NRO_BANCO']." Proprietário: ".$rs_pagamento[$i]['NME_PROPRIETARIO']."\">";
        }else if ($rs_pagamento[$i]['COD_TIPO_PAGAMENTO']==5){
            echo"<tr id=\"".$i."\"
                title=\"Mercadoria: ".$rs_pagamento[$i]['DSC_MERCADORIA']."\">";
               
        }else{
            echo"<tr id=\"".$i."\">"; 
        }

            echo"<td>".$rs_pagamento[$i]['DTA_PAGAMENTO']."</td>
                 <td>".$rs_pagamento[$i]['DSC_TIPO_PAGAMENTO']."</td>
                 <td>".$rs_pagamento[$i]['VLR_PAGAMENTO']."</td>";
        if ($rs_pagamento[$i]['NRO_STATUS_VENDA']!='A'){
            echo"<td>&nbsp;</td>";
        }else{
            echo"     <td><a href=\"javascript:$('#nroSequencial').val(".$rs_pagamento[$i]['NRO_SEQUENCIAL'].");
                                         deletarPagamento(".$i.", ".$rs_pagamento[$i]['VLR_PAGAMENTO'].");\"><img src='../../Resources/images/delete.png' width='20' heigh='20' alt='Remover produto'></a></td>";
        }
            echo" </tr>";
        $vlrTotal = $vlrTotal+$rs_pagamento[$i]['VLR_PAGAMENTO'];
        $i++;
    }
}
?>
</table>