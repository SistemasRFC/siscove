<script src="../../View/Produto/js/CadProdutoView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="codProduto" id="codProduto" value="">
<table width="100%" align="left">
    <tr>
        <td colspan="3">
            <table width="95%" align="left">
                <tr>
                    <td>
                        <div id='jqxWidget'>
                            <div id='jqxTabsProdutos'>
                                <ul>
                                    <li>Cadastro</li>
                                    <li>Receita</li>
                                </ul>
                                <div>
                                    <?php include_once("CadDadosProdutosView.php");?>
                                </div>
                                <div>
                                    <?php include_once("CadDadosReceitaView.php");?>
                                </div>
                            </div> 
                        </div>                         
                    </td>

                </tr>             
            </table>
        </td>
    </tr>     
    <tr>
        <td><input type="button" id="btnSalvarProduto" value="Salvar"></td>
    </tr>
</table>