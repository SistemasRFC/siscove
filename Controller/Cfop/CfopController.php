<?php
include_once("../BaseController.php"); 
include_once("../../Model/Cfop/CfopModel.php");
class CfopController extends BaseController
{
    function CfopController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de Cfop
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarCfop(){
        $CfopModel = new CfopModel();
        echo $CfopModel->ListarCfop();
    }
    
    Public Function InsertCfop(){
        $CfopModel = new CfopModel();
        echo $CfopModel->InsertCfop();
    }

    Public Function UpdateCfop(){
        $CfopModel = new CfopModel();
        echo $CfopModel->UpdateCfop();
    }	
}
$classController = new CfopController();