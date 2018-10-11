<?php
include_once("../BaseController.php"); 
include_once("../../Model/CofinsSituacaoTributaria/CofinsSituacaoTributariaModel.php");
class CofinsSituacaoTributariaController extends BaseController
{
    function CofinsSituacaoTributariaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de CofinsSituacaoTributaria
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarCofinsSituacaoTributaria(){
        $CofinsSituacaoTributariaModel = new CofinsSituacaoTributariaModel();
        echo $CofinsSituacaoTributariaModel->ListarCofinsSituacaoTributaria();
    }
    
    Public Function InsertCofinsSituacaoTributaria(){
        $CofinsSituacaoTributariaModel = new CofinsSituacaoTributariaModel();
        echo $CofinsSituacaoTributariaModel->InsertCofinsSituacaoTributaria();
    }

    Public Function UpdateCofinsSituacaoTributaria(){
        $CofinsSituacaoTributariaModel = new CofinsSituacaoTributariaModel();
        echo $CofinsSituacaoTributariaModel->UpdateCofinsSituacaoTributaria();
    }	
}
$classController = new CofinsSituacaoTributariaController();