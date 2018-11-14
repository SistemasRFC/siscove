<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Cadastro de Clientes</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js?rdm=<?php echo time();?>"></script> 
    <script src="js/ClienteView.js?rdm=<?php echo time();?>"></script>
    
</HEAD>
    <body>    
        <table>
            <tr>
                <td>
                    <table>
                    <tr>
                        <td><input type="button" id="btnNovo" value="Novo Cliente"></td>
                    </tr>
                    <tr>
                        <td>Pesquise o nome do Cliente</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" size="50" name="parametro" id="parametro" value="">
                        </td>
                        <td><input type="button" id="btnPesquisar" value="Pesquisar"></td>
                    </tr> 
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="CadastroForm">
                          <div id="windowHeader">
                          </div>
                          <div style="overflow: hidden;" id="windowContent">
                              <?php include_once("CadClienteView.php");?>
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
</HTML>

