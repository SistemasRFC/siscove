<?php
include_once("../BaseController.php"); 
include_once("../../Model/IcmsOrigem/IcmsOrigemModel.php");
class IcmsOrigemController extends BaseController
{
    function IcmsOrigemController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de IcmsOrigem
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarIcmsOrigem(){
        $IcmsOrigemModel = new IcmsOrigemModel();
        echo $IcmsOrigemModel->ListarIcmsOrigem();
    }
    
    Public Function InsertIcmsOrigem(){
        $IcmsOrigemModel = new IcmsOrigemModel();
        echo $IcmsOrigemModel->InsertIcmsOrigem();
    }

    Public Function UpdateIcmsOrigem(){
        $IcmsOrigemModel = new IcmsOrigemModel();
        echo $IcmsOrigemModel->UpdateIcmsOrigem();
    }	
}
$classController = new IcmsOrigemController();