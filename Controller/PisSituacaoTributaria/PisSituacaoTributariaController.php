<?php
include_once("../BaseController.php"); 
include_once("../../Model/PisSituacaoTributaria/PisSituacaoTributariaModel.php");
class PisSituacaoTributariaController extends BaseController
{
    function PisSituacaoTributariaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de PisSituacaoTributaria
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarPisSituacaoTributaria(){
        $PisSituacaoTributariaModel = new PisSituacaoTributariaModel();
        echo $PisSituacaoTributariaModel->ListarPisSituacaoTributaria();
    }
    
    Public Function InsertPisSituacaoTributaria(){
        $PisSituacaoTributariaModel = new PisSituacaoTributariaModel();
        echo $PisSituacaoTributariaModel->InsertPisSituacaoTributaria();
    }

    Public Function UpdatePisSituacaoTributaria(){
        $PisSituacaoTributariaModel = new PisSituacaoTributariaModel();
        echo $PisSituacaoTributariaModel->UpdatePisSituacaoTributaria();
    }	
}
$classController = new PisSituacaoTributariaController();