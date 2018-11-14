<table width="100%" id="resultado">
    <tr bgcolor="#fdf5ce" style=>
        <td>Vendedor</td>
        <td>Produto</td>
        <td>Qtd.</td>
        <td>Vlr unitário</td>
        <td>Vlr Desconto</td>
        <td>Valor</td>
        <td>&nbsp;</td>
    </tr>
<?php
if (isset($_POST['listaProdutosVendas'])){

    $rs_produtos = unserialize(urldecode($_POST['listaProdutosVendas']));
    $total = count($rs_produtos);
    $i=0;
    $vlrTotal = 0;
    while($i<$total ) {
        echo"<tr id=\"".$i."\">
                 <td>".$rs_produtos[$i]['NME_FUNCIONARIO']."</td>
                 <td>".$rs_produtos[$i]['DSC_PRODUTO']."</td>
                 <td>".$rs_produtos[$i]['QTD_VENDIDA']."</td>
                 <td>".$rs_produtos[$i]['VLR_VENDA']."</td>
                 <td>".$rs_produtos[$i]['VLR_DESCONTO']."</td>
                 <td>".($rs_produtos[$i]['VLR_VENDA']-$rs_produtos[$i]['VLR_DESCONTO'])*$rs_produtos[$i]['QTD_VENDIDA']."</td>";
        if($rs_produtos[$i]['NRO_STATUS_VENDA']!='A'){
           echo" <td>&nbsp;</td>";
        }else{
           echo" <td><a href=\"javascript:deletarProduto(".$i.", ".$rs_produtos[$i]['COD_PRODUTO'].",
                                          ".$rs_produtos[$i]['COD_VENDA'].",
                                          ".$rs_produtos[$i]['NRO_SEQUENCIAL'].",
                                          ".$rs_produtos[$i]['QTD_VENDIDA'].",
                                          ".$rs_produtos[$i]['VLR_VENDA'].",
                                          ".$rs_produtos[$i]['VLR_DESCONTO'].",
                                          '".$rs_produtos[$i]['IND_ESTOQUE']."');\"><img src='../../Resources/images/delete.png' width='20' heigh='20' alt='Remover produto'></a></td>";
        }
        echo"     </tr>";
        $vlrTotal = $vlrTotal+($rs_produtos[$i]['VLR_VENDA']-$rs_produtos[$i]['VLR_DESCONTO'])*$rs_produtos[$i]['QTD_VENDIDA'];
        $i++;
    }
}
?>
</table>