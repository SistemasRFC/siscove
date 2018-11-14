<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Cadastro de Serviço</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="../../View/Servico/js/Funcoes.js?rdm=<?php echo time();?>"></script> 
    <script src="../../View/Servico/js/ServicoView.js?rdm=<?php echo time();?>"></script>
</HEAD>
<BODY>
    <table>
        <tr>
            <td><input type="button" id="btnNovo" value="Novo Serviço"></td>
        </tr> 
            <tr>
                <td>
                    <table>
                    <tr>
                        <td>Pesquise a descri&ccedil;&atilde;o</td>
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
                          <?php include_once("CadServicoView.php");?>
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
</BODY>
</HTML>
