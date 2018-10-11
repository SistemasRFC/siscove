<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/ComissaoFuncionariosModel.php");
class ComissaoFuncionariosController extends BaseController
{
    Public Function ComissaoFuncionariosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Relatorios/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    } 
    
    Public Function DadosComissao(){
        $model = new ComissaoFuncionariosModel();
        echo $model->DadosComissao();
    }

}
$ComissaoFuncionariosController = new ComissaoFuncionariosController();
?>