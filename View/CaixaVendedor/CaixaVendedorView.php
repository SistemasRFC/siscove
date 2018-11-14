<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <head>
    <title>Fechamento de Caixa</title>
    <script src="js/CaixaVendedorView.js?rdm=<?php echo time();?>"></script>      
    </head>
    <body>    
        <table align="left" width="100%" id="fechamento">
            <tr>
                <td>
                    <table width='70%' border='0'>
                        <tr>
                            <td width='15%'>Data do fechamento: </td>
                            <td width='15%'><div id="dtaPagamento"></div></td>
                            <td><input type="button" id="btnPesquisar" value="Pesquisar"></td>
                        </tr>
                    </table>
                </td>
            </tr>            
            <tr>
                <td align="center"><span style="font-size: 20;">Fechamento de caixa</span></td>
            </tr>
            <tr>
                <td class='FechamentoCaixa' id="tabelaPagamentosVendedor"></td>
            </tr>
            <tr>
                <td class='FechamentoCaixa' align="center"><span style="font-size: 20;"><br>Resumo do Fechamento de caixa</span></td>
            </tr>
            <tr>
                <td class='FechamentoCaixa' id="tabelaPagamentosTipo"></td>
            </tr>
            <tr>
                <td>
                    <input  class='FechamentoCaixa' type="button" id="btnFechamento" value="Fechar Caixa">
                    <input type="button" id="btnCaixasFechados" value="Listagem de Caixas Fechados">
                </td>
            </tr>
        </table>
    </body>
</html>
<div id="ListaCaixasFechadosForm">
    <div id="windowHeader">
    </div>
    <div style="overflow: hidden;" id="windowContent">
        <?php include_once("ListaCaixaFechadoView.php");?>
    </div>            
</div>