<?php
include_once("../BaseController.php");
include_once("../../Model/Servico/ServicoModel.php");
class ServicoController extends BaseController
{
    Public Function ServicoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Servico/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);  
    }

    Public Function ListarServico(){
        $model = new ServicoModel();
        echo $model->ListarServico();
    }

    Public Function ListarServicosAtivos(){
        $model = new ServicoModel();
        $lista = $model->ListarServicosAtivos();
    }

    Public Function AddServico(){
        $produtoModel = new ServicoModel();
        echo $produtoModel->AddServico();
    }

    Public Function UpdateServico(){
        $produtoModel = new ServicoModel();
        echo $produtoModel->UpdateServico();
    }
}
$ServicoController = new ServicoController();
?>