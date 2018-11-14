<?php
include_once("../BaseController.php"); 
include_once("../../Model/Ncm/NcmModel.php");
class NcmController extends BaseController
{
    function NcmController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de Ncm
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarNcm(){
        $NcmModel = new NcmModel();
        echo $NcmModel->ListarNcm();
    }
    
    Public Function InsertNcm(){
        $NcmModel = new NcmModel();
        echo $NcmModel->InsertNcm();
    }

    Public Function UpdateNcm(){
        $NcmModel = new NcmModel();
        echo $NcmModel->UpdateNcm();
    }	
}
$classController = new NcmController();