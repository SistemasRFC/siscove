<?php
$dadosVenda = (unserialize(urldecode($_POST['dadosVenda'])));
$dadosProdutosVenda = (unserialize(urldecode($_POST['dadosProdutosVenda'])));
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
                                Ordem de serviço
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
                                Cliente:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['DSC_CLIENTE'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Telefone Celular:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['NRO_TELEFONE_CELULAR'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">
                                Telefone Contato:
                            </td>
                            <td>
                                <?php echo $dadosVenda[0]['NRO_TELEFONE_CONTATO'];?>
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
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="TDTitulo">
                                Funcionário
                            </td>
                            <td class="TDTitulo">
                                Descrição
                            </td>
                            <td align="right" class="TDTitulo">
                                Qtd Vendida
                            </td>
                            <td align="right" class="TDTitulo">
                                Observações
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
                                <?php echo $dadosProdutosVenda[$i]['NME_USUARIO_COMPLETO']?>
                            </td>
                            <td>
                                <?php echo $dadosProdutosVenda[$i]['DSC_PRODUTO']?>
                            </td>
                            <td align="right">
                                <?php echo $dadosProdutosVenda[$i]['QTD_VENDIDA']?>
                            </td>
                            <td align="right">
                                <?php echo $dadosProdutosVenda[$i]['TXT_OBSERVACAO'];?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </table>
                </td>
            </tr>            
            <tr>
                <td>
                    <table width="100%" class="TabelaCabecalho">
                        <tr>
                            <td class="TDTituloCabecalho" style='text-align: left;'>
                                Data de Entrada: _______/_________/_________
                            </td>
                            <td class="TDTituloCabecalho" style='text-align: left;'>
                                Data de Entrega: _______/_________/_________
                            </td>
                        </tr>                            
                        <tr>
                            <td class="TDTituloCabecalho" style='text-align: left;'>
                                Responsável:________________________________
                            </td>
                        </tr>
                    </table>        
                </td>
            </tr>    
        </table>
    </body>
</html>