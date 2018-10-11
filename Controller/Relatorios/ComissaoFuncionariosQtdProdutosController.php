<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/ComissaoFuncionariosQtdProdutosModel.php");
class ComissaoFuncionariosQtdProdutosController extends BaseController
{
    Public Function ComissaoFuncionariosQtdProdutosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Relatorios/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    } 
    
    Public Function DadosComissao(){
        $model = new ComissaoFuncionariosQtdProdutosModel();
        echo $model->DadosComissao();
    }

}
$ComissaoFuncionariosQtdProdutosController = new ComissaoFuncionariosQtdProdutosController();
?>