<?php
$dadosVenda = (unserialize(urldecode($_POST['dadosVenda'])));
$dadosProdutosVenda = (unserialize(urldecode($_POST['dadosProdutosVenda'])));
$dadosPagamentosVenda = (unserialize(urldecode($_POST['dadosPagamentosVenda'])));
?>
<html>
<HEAD>
<TITLE>P&aacute;gina Principal</TITLE>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <link href="../../Resources/css/style.css" rel="stylesheet">
</head>
    <body>
        <table width="100%">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td class="TDTituloCabecalho">
                                Resumo da venda
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaCabecalho">
                        <tr>
                            <td width="20%" class="TDTitulo">
                                Código da Venda: 
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['COD_VENDA'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Data da Venda:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['DTA_VENDA'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                CPF:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['NRO_CPF'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Cliente:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['DSC_CLIENTE'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Vendedor:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['NME_USUARIO_COMPLETO'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Veículo:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['DSC_VEICULO'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Placa:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['NRO_PLACA'];?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td class="TDTituloCabecalho">
                                Produtos desta venda
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2">
                        <tr>
                            <td class="TDTitulo">
                                Funcionário
                            </td>
                            <td class="TDTitulo">
                                Descrição
                            </td>
                            <td class="TDTitulo">
                                Marca
                            </td>
                            <td align="right" class="TDTitulo">
                                Valor de venda
                            </td>
                            <td align="right" class="TDTitulo">
                                Qtd Vendida
                            </td>
                            <td align="right" class="TDTitulo">
                                Valor Desconto
                            </td>
                            <td align="right" class="TDTitulo">
                                Total Unitário
                            </td>
                        </tr>
                        <?php
                        $corLinha = "white";
                        $i=0;
                        $total = count($dadosProdutosVenda);
                        $vlrTotal = 0;
                        while ($i<$total){
                            if ($corLinha=="white"){
                                $corLinha="E8E8E8";
                            }else{
                                $corLinha="white";
                            }?>

                        <tr bgcolor="<?echo $corLinha?>" class="trcor">
                            <td>
                                <?echo $dadosProdutosVenda[$i]['NME_USUARIO_COMPLETO']?>
                            </td>
                            <td>
                                <?echo $dadosProdutosVenda[$i]['DSC_PRODUTO']?>
                            </td>
                            <td>
                                <?echo $dadosProdutosVenda[$i]['DSC_MARCA']?>
                            </td>
                            <td align="right">
                               R$ <?echo number_format($dadosProdutosVenda[$i]['VLR_VENDA'],2)?>
                            </td>
                            <td align="right">
                                <?echo $dadosProdutosVenda[$i]['QTD_VENDIDA']?>
                            </td>
                            <td align="right">
                               R$ <?echo number_format($dadosProdutosVenda[$i]['VLR_DESCONTO'],2)?>
                            </td>
                            <td align="right">
                               R$ <?echo number_format($dadosProdutosVenda[$i]['VLR_TOTAL'],2)?>
                            </td>
                        </tr>
                        <?$vlrTotal = $vlrTotal+$dadosProdutosVenda[$i]['VLR_TOTAL'];
                        $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="6" align="right" class="TDTitulo">
                                Total
                            </td>
                            <td align="right">
                               R$ <?echo number_format($vlrTotal,2)?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php // include_once('CheckListView.php');?>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td class="TDTituloCabecalho">
                                Pagamentos desta venda
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2">
                        <tr>
                            <td class="TDTitulo">
                                Data
                            </td>
                            <td class="TDTitulo">
                                Tipo
                            </td>
                            <td class="TDTitulo" align="right">
                                Valor
                            </td>
                        </tr>
                        <?
                        $corLinha = "white";
                        $i=0;
                        $total = count($dadosPagamentosVenda);
                        $vlrTotal = 0;
                        while ($i<$total){
                            if ($corLinha=="white"){
                                $corLinha="E8E8E8";
                            }else{
                                $corLinha="white";
                            }?>
                        <tr bgcolor="<?echo $corLinha?>" class="trcor">
                            <td>
                                <?echo $dadosPagamentosVenda[$i]['DTA_PAGAMENTO']?>
                            </td>
                            <td>
                                <?echo $dadosPagamentosVenda[$i]['DSC_TIPO_PAGAMENTO']?>
                            </td>
                            <td align="right">
                                R$ <?echo number_format($dadosPagamentosVenda[$i]['VLR_PAGAMENTO'],2)?>
                            </td>
                        </tr>
                        <?$vlrTotal = $vlrTotal+$dadosPagamentosVenda[$i]['VLR_PAGAMENTO'];
                        $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="2" align="right" class="TDTitulo">
                                Total
                            </td>
                            <td align="right">
                               R$ <?echo number_format($vlrTotal,2)?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>            
        </table>
    </body>
</html>