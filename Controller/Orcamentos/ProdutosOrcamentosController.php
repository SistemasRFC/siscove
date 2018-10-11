<?php
include_once("../BaseController.php");
include_once("../../Model/Orcamentos/ProdutosOrcamentosModel.php");
class ProdutosOrcamentosController extends BaseController
{
    Public Function ProdutosOrcamentosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ListarDadosProdutosVenda(){
        $produtosOrcamentosModel = new ProdutosOrcamentosModel();
        echo $produtosOrcamentosModel->ListarDadosProdutosVenda();
    }

    Public Function InserirProduto(){        
        $produtosOrcamentosModel = new ProdutosOrcamentosModel();
        $dado = $produtosOrcamentosModel->InserirProduto();
        echo "'".$dado."'";
    }

    Public Function DeletarProdutoVenda(){        
        $produtosOrcamentosModel = new ProdutosOrcamentosModel();
        $dado = $produtosOrcamentosModel->DeletarProdutoVenda();
        echo $dado;
    }
}
$produtoOrcamentosController = new ProdutosOrcamentosController();
?>