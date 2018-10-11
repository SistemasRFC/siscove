<?php
include_once("../BaseController.php"); 
include_once("../../Model/CaixaVendedor/CaixaVendedorModel.php");
class CaixaVendedorController extends BaseController
{
    function CaixaVendedorController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de CaixaVendedor
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarPagamentosVendedor(){
        $CaixaVendedorModel = new CaixaVendedorModel();
        echo $CaixaVendedorModel->ListarPagamentosVendedor();
    }	

    Public Function FecharCaixaVendedor(){
        $CaixaVendedorModel = new CaixaVendedorModel();
        echo $CaixaVendedorModel->FecharCaixaVendedor();
    }

    Public Function ListarCaixaVendedor(){
        $CaixaVendedorModel = new CaixaVendedorModel();
        echo $CaixaVendedorModel->ListarCaixaVendedor();
    }

    Public Function ListarCaixaPorCodigoVendedor(){
        $CaixaVendedorModel = new CaixaVendedorModel();
        echo $CaixaVendedorModel->ListarCaixaPorCodigoVendedor();
    }    
    
}
$classController = new CaixaVendedorController();