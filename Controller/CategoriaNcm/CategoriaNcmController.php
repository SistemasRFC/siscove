<?php
include_once("../BaseController.php"); 
include_once("../../Model/CategoriaNcm/CategoriaNcmModel.php");
class CategoriaNcmController extends BaseController
{
    function CategoriaNcmController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de CategoriaNcm
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarCategoriaNcm(){
        $CategoriaNcmModel = new CategoriaNcmModel();
        echo $CategoriaNcmModel->ListarCategoriaNcm();
    }
    
    Public Function InsertCategoriaNcm(){
        $CategoriaNcmModel = new CategoriaNcmModel();
        echo $CategoriaNcmModel->InsertCategoriaNcm();
    }

    Public Function UpdateCategoriaNcm(){
        $CategoriaNcmModel = new CategoriaNcmModel();
        echo $CategoriaNcmModel->UpdateCategoriaNcm();
    }	
}
$classController = new CategoriaNcmController();