<?php
include_once("../BaseController.php"); 
include_once("../../Model/CaixaGerencia/CaixaGerenciaModel.php");
class CaixaGerenciaController extends BaseController
{
    function CaixaGerenciaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de CaixaGerencia
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarCaixasFechadosGerencia(){
        $CaixaGerenciaModel = new CaixaGerenciaModel();
        echo $CaixaGerenciaModel->ListarCaixasFechadosGerencia();
    }

    Public Function ListarCaixasVendedor(){
        $CaixaGerenciaModel = new CaixaGerenciaModel();
        echo $CaixaGerenciaModel->ListarCaixasVendedor();
    }	  
    
    Public Function FecharCaixaGerencia(){
        $CaixaGerenciaModel = new CaixaGerenciaModel();
        echo $CaixaGerenciaModel->FecharCaixaGerencia();
        
    }

    Public Function ListarCaixasVendedorPorCodigo(){
        $CaixaGerenciaModel = new CaixaGerenciaModel();
        echo $CaixaGerenciaModel->ListarCaixasVendedorPorCodigo();
    }
}
$classController = new CaixaGerenciaController();