<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <head>
        <title>Cadastro de Venda</title>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        <script src="js/CartaCorrecaoView.js?ramdom=<?php echo time();?>"></script>
    </head>
    <body>
    <input type="hidden" id="method" name="method">
    <table width="100%" id="ListarSequenciais">
        <tr>
            <td width="100%"
                style="text-align:left;
                height:10%;
                font-size:18px;
                color:#a4bed4;
                vertical-align:middle;
                font-family: arial, helvetica, serif;
                border-bottom: 1px solid #a4bed4;">
                Listagem de Referências
            </td>
        </tr>
        <tr>
            <td id="tdSequenciais">
                <div id="listaSequenciais"></div>
            </td>
        </tr>
    </table>
    </body>
</html>