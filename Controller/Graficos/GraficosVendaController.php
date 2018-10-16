<?php
include_once("../BaseController.php");
include_once("../../Model/GraficosVenda/GraficosVendaModel.php");
class GraficosVendaController extends BaseController{
    
    Public Function GraficosVendaController(){ 
      eval("\$this->".BaseController::getMethod()."();");
    }
    
    Public Function ChamaView(){
        $view = $this->getPath()."/View/Graficos/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }
    
    Public Function SelecionaDados(){
        $model = new GraficosVendaModel();
        echo $model->SelecionaDados();
    }
    
}
new GraficosVendaController();