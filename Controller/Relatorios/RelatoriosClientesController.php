<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatoriosClientesModel.php");
class RelatoriosClientesController extends BaseController
{
    Public Function RelatoriosClientesController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ListaClientes(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/ListaClientesView.php";
        echo ($this->gen_redirect_and_form($view, $params, "", "_blank"));
    }
    
    Public Function DadosClientes(){
        $model = new RelatoriosClientesModel();
        echo $model->DadosClientes();
    }
}
$RelatoriosClientesController = new RelatoriosClientesController();
?>