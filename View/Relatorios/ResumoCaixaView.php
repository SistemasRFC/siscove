<?php
$dadosCaixa = (unserialize(urldecode($_POST['dadosCaixa'])));
$dadosPagamentosVenda = (unserialize(urldecode($_POST['dadosPagamentosVenda'])));
?>
<html>
<HEAD>
<TITLE>Resumo de venda</TITLE>
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
                                <?php echo $dadosCaixa[0]['COD_VENDA'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Data da Venda:
                            </td>
                            <td>
                                <?php echo $dadosCaixa[0]['DTA_VENDA'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Cliente:
                            </td>
                            <td>
                                <?php echo $dadosCaixa[0]['DSC_CLIENTE'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Vendedor:
                            </td>
                            <td>
                                <?php echo $dadosCaixa[0]['NME_USUARIO_COMPLETO'];?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>            
            <?php include_once('CheckListView.php');?>
            <tr>
                <td>
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0">
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
                        <?php
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
                                <?php echo $dadosPagamentosVenda[$i]['DTA_PAGAMENTO']?>
                            </td>
                            <td>
                                <?php echo $dadosPagamentosVenda[$i]['DSC_TIPO_PAGAMENTO']?>
                            </td>
                            <td align="right">
                                R$ <?php echo number_format($dadosPagamentosVenda[$i]['VLR_PAGAMENTO'],2)?>
                            </td>
                        </tr>
                        <?php $vlrTotal = $vlrTotal+$dadosPagamentosVenda[$i]['VLR_PAGAMENTO'];
                        $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="2" align="right">
                                Total
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($vlrTotal,2)?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>            
        </table>
    </body>
</html>