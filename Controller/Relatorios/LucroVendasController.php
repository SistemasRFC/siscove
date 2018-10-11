<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/LucroVendasModel.php");
class LucroVendasController extends BaseController
{
    Public Function LucroVendasController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Relatorios/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }
    
    Public Function DadosComissao(){
        $model = new LucroVendasModel();
        echo $model->DadosComissao();                
    }

}
$LucroVendasController = new LucroVendasController();
?>