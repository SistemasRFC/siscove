<html>
<HEAD>
<TITLE>P&aacute;gina Principal</TITLE>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script language="JavaScript" type="text/JavaScript"></script>
    <script src="../../Resources/JavaScript.js"></script>
    <link href="../../Resources/css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <link href="../../Resources/css/style.css" rel="stylesheet">
    <script src="../../Resources/js/jquery-1.9.0.js"></script>
    <script src="../../Resources/js/jquery-ui-1.10.0.custom.js"></script>
    <script src="../../Resources/js/jquery.maskMoney.js"></script>
    <script src="../../Resources/js/svJavaScript.js"></script>
    <script src="js/GerarVendaView.js"></script>
</HEAD>
<BODY>
    <div id="CadastroForm">
        <form name="ProdutosVendasForm" id="ProdutosVendasForm" method="post" action="../../Controller/Vendas/ProdutosVendasController.php">
        <input type="hidden" name="method" id="method" value="">
        <input type="hidden" name="codProdutoVenda" id="codProdutoVenda" value="">
        <input type="hidden" name="nroStatusVenda" id="nroStatusVenda"
               value="<?
                       if (isset($_POST['nroStatusVenda'])){
                           echo $_POST['nroStatusVenda'];
                       }
                       ?>">
        <input type="hidden" name="codVenda" id="codVenda"
               value="<?
                       if (isset($_POST['codVenda'])){
                           echo unserialize(urldecode($_POST['codVenda']));
                       }
                       ?>">

        <table width="100%" align="center" border="0">
        <tr>
        <td>Dados do Orçamento
            <table width="100%" align="center">
            <tr>
                <td style="font-size:14px;" align="left">
                    Data do Orçamento: <?echo unserialize(urldecode($_POST['dtaVenda']));?>
                </td>
                <td style="font-size:14px;" align="left">
                    Vendedor: <?echo unserialize(urldecode($_POST['nmeVendedor']));?>
                </td>
            </tr>
            <tr>
                <td style="font-size:14px;" align="left">
                    Cliente: <?echo unserialize(urldecode($_POST['dscCliente']));?>
                </td>
            </tr>
            <tr>
                <td style="font-size:14px;" align="left">
                    Veículo: <?echo unserialize(urldecode($_POST['dscVeiculo']));?>
                </td>
            </tr>
            </table>
        </td>
        </tr>        
        <tr>
            <td>
                <table width="100%" border="0" align="left">
                    <tr>
                        <td>
                            <div>
                                <?include("TabelaProdutosVendasView.php");?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" align="left">
                    <tr>
                        <td class="TDTitulo">
                            Valor total da venda: R$ <input id="vlrTotalVenda" name="vlrTotalVenda"
                                                            style="border:0px;
                                                                   background-color: transparent;"
                                                            readonly
                                                            value="<?echo number_format($vlrTotal,2);?>">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
        </form>
    </div>
<div id="dialogInformacao">
</div>
    <div id="tabela">
    </div>
</BODY>
</HTML>