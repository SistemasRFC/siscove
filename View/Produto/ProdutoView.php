<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Cadastro de Produtos</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js?rdm=<?php echo time();?>"></script> 
    <script src="js/ProdutoView.js?rdm=<?php echo time();?>"></script>
</HEAD>
<BODY>
    <table>
        <tr>
            <td><input type="button" id="btnNovo" value="Novo Produto"></td>
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
                          <?php include_once("CadProdutosView.php");?>
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
