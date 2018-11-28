<?php
$dadosVenda = (unserialize(urldecode($_POST['dadosVenda'])));
$dadosProdutosVenda = (unserialize(urldecode($_POST['dadosProdutosVenda'])));
$dadosPagamentosVenda = (unserialize(urldecode($_POST['dadosPagamentosVenda'])));
?>
<html>
    <head>
        <title> Carta de Correção</title>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        <link href="../../Resources/css/style.css" rel="stylesheet">
        <script src="js/CartaCorrecaoView.js?ramdom=<?php echo time();?>"></script>
    </head>
    <body>
    <input type="hidden" id="notaReferencia" name="notaReferencia" value="<?php echo $_REQUEST['referencia'];?>">
    <?php if($dadosVenda !== ''){ ?>
    <table width="100%">
            <tr>
                <td class="TDTituloCabecalho">
                    Resumo da venda
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
                <td class="TDTituloCabecalho">
                    Produtos desta venda
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

                        <tr bgcolor="<?php echo $corLinha?>" class="trcor">
                            <td>
                                <?php echo $dadosProdutosVenda[$i]['NME_USUARIO_COMPLETO']?>
                            </td>
                            <td>
                                <?php echo $dadosProdutosVenda[$i]['DSC_PRODUTO']?>
                            </td>
                            <td>
                                <?php echo $dadosProdutosVenda[$i]['DSC_MARCA']?>
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($dadosProdutosVenda[$i]['VLR_VENDA'],2)?>
                            </td>
                            <td align="right">
                                <?php echo $dadosProdutosVenda[$i]['QTD_VENDIDA']?>
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($dadosProdutosVenda[$i]['VLR_DESCONTO'],2)?>
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($dadosProdutosVenda[$i]['VLR_TOTAL'],2)?>
                            </td>
                        </tr>
                        <?php $vlrTotal = $vlrTotal+$dadosProdutosVenda[$i]['VLR_TOTAL'];
                        $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="6" align="right" class="TDTitulo">
                                Total
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($vlrTotal,2)?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="TDTituloCabecalho">
                    Pagamentos desta venda
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
                        <tr bgcolor="<?php echo $corLinha?>" class="trcor">
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
                            <td colspan="2" align="right" class="TDTitulo">
                                Total
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($vlrTotal,2)?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
    <?php } else {?>
        <table width="100%">
            <tr>
                <td class="TDTituloCabecalho">
                    Resumo da Entrada
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaCabecalho">
                        <tr>
                            <td class="TDTitulo">
                                Data da Entrada:
                            </td>
                            <td>
                                <?php echo $dadosEntrada[0]['DTA_ENTRADA'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Cnpj:
                            </td>
                            <td>
                                <?php echo $dadosEntrada[0]['NRO_CNPJ'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Fornecedor:
                            </td>
                            <td>
                                <?php echo $dadosEntrada[0]['NME_FORNECEDOR'];?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="TDTituloCabecalho">
                    Produtos desta Entrada
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2">
                        <tr>
                            <td class="TDTitulo">
                                Descrição
                            </td>
                            <td class="TDTitulo">
                                Marca
                            </td>
                            <td align="right" class="TDTitulo">
                                Valor Unitário
                            </td>
                            <td align="right" class="TDTitulo">
                                Quantidade
                            </td>
                            <td align="right" class="TDTitulo">
                                Valor Total
                            </td>
                        </tr>
                        <?php
                        $corLinha = "white";
                        $i=0;
                        $total = count($dadosProdutosEntrada);
                        $vlrTotal = 0;
                        while ($i<$total){
                            if ($corLinha=="white"){
                                $corLinha="E8E8E8";
                            }else{
                                $corLinha="white";
                            }?>

                        <tr bgcolor="<?php echo $corLinha?>" class="trcor">
                            <td>
                                <?php echo $dadosProdutosEntrada[$i]['DSC_PRODUTO']?>
                            </td>
                            <td>
                                <?php echo $dadosProdutosEntrada[$i]['DSC_MARCA']?>
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($dadosProdutosEntrada[$i]['VLR_UNITARIO'],2)?><!--CONFERIR-->
                            </td>
                            <td align="right">
                                <?php echo $dadosProdutosEntrada[$i]['QTD_VENDIDA']?><!--CONFERIR-->
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($dadosProdutosEntrada[$i]['VLR_TOTAL'],2)?>
                            </td>
                        </tr>
                        <?php $vlrTotal = $vlrTotal+$dadosProdutosEntrada[$i]['VLR_TOTAL'];
                        $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="6" align="right" class="TDTitulo">
                                Total
                            </td>
                            <td align="right">
                               R$ <?php echo number_format($vlrTotal,2)?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
    <?php } ?>
            <tr>
                <td class="TDTituloCabecalho">
                    Carta de Correção
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2">
                        <tr>
                            <td align="center">
                                <textarea style="border-color: #000000;" name="dscCartaCorrecao" id="dscCartaCorrecao" cols="80" rows="7"
                                    placeholder="Informe as correções aqui!"></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="button" name="btnEnviarCartaCorrecao" id="btnEnviarCartaCorrecao" value="Enviar Carta">
                </td>
            </tr>
        </table>
    </body>
</html>