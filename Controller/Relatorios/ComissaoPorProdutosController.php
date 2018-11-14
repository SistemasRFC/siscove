<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/ComissaoPorProdutosModel.php");
class ComissaoPorProdutosController extends BaseController
{
    Public Function ComissaoPorProdutosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Relatorios/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }
    Public Function DadosComissao(){
        $model = new ComissaoPorProdutosModel();
        echo $model->DadosComissao();
    }

}
$ComissaoPorProdutosController = new ComissaoPorProdutosController();
?>