<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatoriosClientesVendasModel.php");
class RelatoriosVendasController extends BaseController
{
    Public Function RelatoriosVendasController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaVendasAbertas(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/ClientesVendasView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function QtdVendasPorCliente(){
        $model = new RelatoriosClientesVendasModel();
        $dadosComissao = $model->QtdVendasPorCliente();
        echo $dadosComissao;
        flush();
    }
}
$RelatoriosVendasController = new RelatoriosVendasController();
?>