<?php
include_once("../BaseController.php"); 
include_once("../../Model/VendaReferencia/VendaReferenciaModel.php");
class VendaReferenciaController extends BaseController
{
    function VendaReferenciaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de VendaReferencia
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarVendaReferencia(){
        $VendaReferenciaModel = new VendaReferenciaModel();
        echo $VendaReferenciaModel->ListarVendaReferencia();
    }
    
    Public Function InsertVendaReferencia(){
        $VendaReferenciaModel = new VendaReferenciaModel();
        echo $VendaReferenciaModel->InsertVendaReferencia();
    }

    Public Function UpdateVendaReferencia(){
        $VendaReferenciaModel = new VendaReferenciaModel();
        echo $VendaReferenciaModel->UpdateVendaReferencia();
    }	
}
$classController = new VendaReferenciaController();