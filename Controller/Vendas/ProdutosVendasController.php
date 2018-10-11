<?php
include_once("../BaseController.php");
include_once("../../Model/Vendas/ProdutosVendasModel.php");
class ProdutosVendasController extends BaseController
{
    Public Function ProdutosVendasController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ListarDadosProdutosVenda(){
        $produtosVendasModel = new ProdutosVendasModel();
        echo $produtosVendasModel->ListarDadosProdutosVenda();
    }

    Public Function InserirProduto(){        
        $produtosVendasModel = new ProdutosVendasModel();
        $dado = $produtosVendasModel->InserirProduto();
        echo "'".$dado."'";
    }

    Public Function DeletarProdutoVenda(){        
        $produtosVendasModel = new ProdutosVendasModel();
        $dado = $produtosVendasModel->DeletarProdutoVenda();
        echo $dado;
    }
}
$produtoVendasController = new ProdutosVendasController();
?>