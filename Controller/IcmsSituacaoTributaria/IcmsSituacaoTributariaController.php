<?php
include_once("../BaseController.php"); 
include_once("../../Model/IcmsSituacaoTributaria/IcmsSituacaoTributariaModel.php");
class IcmsSituacaoTributariaController extends BaseController
{
    function IcmsSituacaoTributariaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de IcmsSituacaoTributaria
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarIcmsSituacaoTributaria(){
        $IcmsSituacaoTributariaModel = new IcmsSituacaoTributariaModel();
        echo $IcmsSituacaoTributariaModel->ListarIcmsSituacaoTributaria();
    }
    
    Public Function InsertIcmsSituacaoTributaria(){
        $IcmsSituacaoTributariaModel = new IcmsSituacaoTributariaModel();
        echo $IcmsSituacaoTributariaModel->InsertIcmsSituacaoTributaria();
    }

    Public Function UpdateIcmsSituacaoTributaria(){
        $IcmsSituacaoTributariaModel = new IcmsSituacaoTributariaModel();
        echo $IcmsSituacaoTributariaModel->UpdateIcmsSituacaoTributaria();
    }	
}
$classController = new IcmsSituacaoTributariaController();