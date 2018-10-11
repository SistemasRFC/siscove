<?php
include_once("../BaseController.php");
include_once("../../Model/TipoProduto/TipoProdutoModel.php");
class TipoProdutoController extends BaseController
{
    Public Function TipoProdutoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/TipoProduto/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }

    Public Function ListarTipoProduto(){
        $model = new TipoProdutoModel();
        echo $model->ListarTipoProduto();
    }

    Public Function ListarTipoProdutosAtivos(){
        $model = new TipoProdutoModel();
        echo $model->ListarTipoProdutosAtivos();
    }

    Public Function AddTipoProduto(){
        $model = new TipoProdutoModel();
        echo $model->AddTipoProduto();
    }
    Public Function UpdateTipoProduto(){
        $model = new TipoProdutoModel();
        echo $model->UpdateTipoProduto();
    }
}
$TipoProdutoController = new TipoProdutoController();
?>