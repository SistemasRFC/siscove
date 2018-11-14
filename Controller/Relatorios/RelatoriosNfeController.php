<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatoriosNfeModel.php");
class RelatoriosNfeController extends BaseController
{
    Public Function RelatoriosNfeController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    

    Public Function ChamaNotasEmitidas(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/RelatorioNfeEmitidasView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public function ListarNotasEmitidas(){
        $model = new RelatoriosNfeModel();
        $lista = $model->ListarNotasEmitidas();
        echo $lista;
    }
}
$RelatoriosNfeController = new RelatoriosNfeController();
?>