<?php
include_once("../BaseController.php");
include_once("../../Model/Produto/ProdutoModel.php");
class ProdutoController extends BaseController
{
    Public Function ProdutoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Produto/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);  
    }

    Public Function ListarProduto(){
        $model = new ProdutoModel();
        echo $model->ListarProduto();
    }

    Public Function AddProduto(){
        $produtoModel = new ProdutoModel();
        echo $produtoModel->AddProduto();  
    }

    Public Function UpdateProduto(){
        $produtoModel = new ProdutoModel();
        echo $produtoModel->UpdateProduto();  
    }
    
    Public Function ListarProdutosVendasAutoComplete(){
        $produtoModel = new ProdutoModel();
        echo $produtoModel->ListarProdutosVendasAutoComplete();
    }
    
    Public Function ListarProdutosAutoComplete(){
        $produtoModel = new ProdutoModel();
        echo $produtoModel->ListarProdutosAutoComplete();
    }
    
    Public Function ListarProdutosAtivos(){
        $produtoModel = new ProdutoModel();
        echo $produtoModel->ListarProdutosAtivos();
    }
}
$ProdutoController = new ProdutoController();
?>