<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <head>
    <title>Controle de Contas</title>
    <script src="js/Funcoes.js"></script> 
    <script src="js/ClienteFinalView.js"></script>      
    </head>
    <body>    
        <table>
            <tr>
                <td><input type="button" id="btnNovo" value="Novo"></td>
            </tr>
            <tr>
                <td>
                    <div id="CadastroForm">
                          <div id="windowHeader">
                          </div>
                          <div style="overflow: hidden;" id="windowContent">
                              <?include_once("CadClienteFinalView.php");?>
                          </div>            
                    </div>  
                </td>
            </tr>
            <tr>
                <td id="tdGrid">
                    <div id="ListagemForm">
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>