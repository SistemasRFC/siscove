<?php
include_once("../BaseController.php");
include_once("../../Model/ClienteFinal/ClienteFinalModel.php");
class ClienteFinalController extends BaseController
{
    Public Function ClienteFinalController(){  
        eval("\$this->".BaseController::getMethod()."();");
    }
    
    Public Function ChamaView(){
        $params = array();
        $view = $this->getPath()."/View/ClienteFinal/".str_replace("Controller", "View", get_class($this)).".php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function ListarClienteFinal(){
        $ClienteFinalModel = new ClienteFinalModel();
        echo $ClienteFinalModel->ListarClienteFinal();
    }
    
    Public Function ListarClienteFinalAtivo(){
        $ClienteFinalModel = new ClienteFinalModel();
        echo $ClienteFinalModel->ListarClienteFinalAtivo();
    }
    
    Public Function UpdateCliente(){
        $ClienteFinalModel = new ClienteFinalModel();
        echo $ClienteFinalModel->UpdateCliente();   
    }
    
    Public Function AddCliente(){
        $ClienteFinalModel = new ClienteFinalModel();
        echo $ClienteFinalModel->AddCliente();   
    }
}
$ClienteFinalController = new ClienteFinalController();
?>