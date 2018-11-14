<?php
include_once("../BaseController.php");
include_once("../../Model/TipoPagamento/TipoPagamentoModel.php");
class TipoPagamentoController extends BaseController
{
    Public Function TipoPagamentoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/TipoPagamento/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }

    Public Function ListarTipoPagamento(){
        $model = new TipoPagamentoModel();
        echo $model->ListarTipoPagamento();
    }

    Public Function ListarTipoPagamentoAtivo(){
        $model = new TipoPagamentoModel();
        echo $model->ListarTipoPagamentoAtivo();
    }

    Public Function AddTipoPagamento(){
        $model = new TipoPagamentoModel();
        echo $model->AddTipoPagamento();
    }
    Public Function UpdateTipoPagamento(){
        $model = new TipoPagamentoModel();
        echo $model->UpdateTipoPagamento();
    }
}
$TipoPagamentoController = new TipoPagamentoController();
?>