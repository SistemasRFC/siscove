<?php include_once "../../View/MenuPrincipal/Cabecalho.php"; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro - kart</title>
        <script src="../MontaFile/JavaScript/MontaFileView.js?rdm=<?php echo time();?>"></script>        
    </head>
    <body>
        <input type="hidden" id="method">
        <input type="hidden" id="codUsuario">
        <table>
            <tr>
                <td>
                    <input type="button" id="Refresh" value="Atualiza" onclick="javascript:MontaListaTabelas();">
                </td>
            </tr>
            <tr>
                <td id="listaTabelas">
                </td>
            </tr>
        </table>
    </body>
</html>
