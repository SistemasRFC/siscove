<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/ComissaoVendedoresModel.php");
class ComissaoVendedoresController extends BaseController
{
    Public Function ComissaoVendedoresController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Relatorios/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }
    Public Function DadosComissao(){
        $model = new ComissaoVendedoresModel();
        echo $model->DadosComissao();
    }

}
$ComissaoVendedoresController = new ComissaoVendedoresController();
?>