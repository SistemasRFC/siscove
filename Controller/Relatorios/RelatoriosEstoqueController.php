<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatoriosEstoqueModel.php");
class RelatoriosEstoqueController extends BaseController
{
    Public Function RelatoriosEstoqueController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
    * Chama o relatório de histórico do estoque
    */
    Public Function ChamaHistoricoEstoque(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/HistoricoEstoqueView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    function ListarHistoricoEstoque(){
        $model = new RelatoriosEstoqueModel();
        echo $model->ListarHistoricoEstoque();
    }
    Public Function ChamaProdutosMaisVendidos(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/ProdutosMaisVendidosView.php";
        echo ($this->gen_redirect_and_form($view, $params));  
    }
    function ListarProdutosMaisVendidos(){
        $model = new RelatoriosEstoqueModel();
        $dadosComissao = $model->ListarProdutosMaisVendidos();
        echo $dadosComissao;
        flush();
    }

    function ChamaPesquisa(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/PesquisaProdutosEstoque.php";
        echo ($this->gen_redirect_and_form($view, $params));

    }
    function ChamaPesquisaGerente(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/PesquisaProdutosEstoqueGerente.php";
        echo ($this->gen_redirect_and_form($view, $params));

    }
    /**
     * Faz a pesquisa de produtos no estoque
     */
    function PesquisaProdutoEstoque(){
        $model = new RelatoriosEstoqueModel();
        echo $model->PesquisaProdutoEstoque();
    }

    Public Function ChamaListarEstoque(){ 
        $params = array();                       
        $view = $this->getPath()."/View/Relatorios/EstoqueProdutosView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    function ListarEstoque(){
        $model = new RelatoriosEstoqueModel();
        echo $model->ListarEstoque();
    }

    Public Function ChamaListarEstoqueProduto(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/RelatorioEstoqueProdutoView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }

    Public Function ListarEstoqueProduto(){
        $model = new RelatoriosEstoqueModel();
        echo $model->ListarEstoqueProduto();
    }

}
$RelatoriosEstoqueController = new RelatoriosEstoqueController();
?>