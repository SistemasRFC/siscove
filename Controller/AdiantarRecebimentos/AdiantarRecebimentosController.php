<?php
include_once("../BaseController.php");
include_once("../../Model/AdiantarRecebimentos/AdiantarRecebimentosModel.php");
class AdiantarRecebimentosController extends BaseController
{
    Public Function AdiantarRecebimentosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/AdiantarRecebimentos/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);  
    }

    Public Function ListarAdiantarRecebimentos(){
        $model = new AdiantarRecebimentosModel();
        echo $model->ListarAdiantarRecebimentos();
    }

    Public Function AddAdiantarRecebimentos(){
        $produtoModel = new AdiantarRecebimentosModel();
        echo $produtoModel->AddAdiantarRecebimentos();  
    }

    Public Function UpdateAdiantarRecebimentos(){
        $produtoModel = new AdiantarRecebimentosModel();
        echo $produtoModel->UpdateAdiantarRecebimentos();  
    }
}
$AdiantarRecebimentosController = new AdiantarRecebimentosController();
?>