<?php
include_once("../BaseController.php");
include_once("../../Model/TipoConta/TipoContaModel.php");
class TipoContaController extends BaseController
{
    Public Function TipoContaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/TipoConta/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }

    Public Function ListarTipoConta(){
        $model = new TipoContaModel();
        echo $model->ListarTipoConta();
    }

    Public Function ListarTipoContaAtivoPesquisa(){
        $model = new TipoContaModel();
        echo $model->ListarTipoContaAtivoPesquisa();
    }

    Public Function ListarTipoContaAtivo(){
        $model = new TipoContaModel();
        echo $model->ListarTipoContaAtivo();
    }

    Public Function AddTipoConta(){
        $model = new TipoContaModel();
        echo $model->AddTipoConta();
    }
    Public Function UpdateTipoConta(){
        $model = new TipoContaModel();
        echo $model->UpdateTipoConta();
    }
}
$TipoContaController = new TipoContaController();
?>