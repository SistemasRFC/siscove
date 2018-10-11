<?php
include_once("../BaseController.php");
include_once("../../Model/Fornecedor/FornecedorModel.php");
class FornecedorController extends BaseController
{
    Public Function FornecedorController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
      $view = $this->getPath()."/View/Fornecedor/".str_replace("Controller", "View", get_class($this)).".php";
      header("Location: ".$view);
    }

    Public Function ListarFornecedorGrid(){
        $model = new FornecedorModel();
        echo $model->ListarFornecedorGrid();
    }

    Public Function ListarFornecedorAtivo(){
        $model = new FornecedorModel();
        echo $model->ListarFornecedorAtivo();
    }

    Public Function AddFornecedor(){
        $model = new FornecedorModel();
        echo $model->AddFornecedor();
    }
    Public Function UpdateFornecedor(){
        $model = new FornecedorModel();
        echo $model->UpdateFornecedor();
    }

    Public Function DeleteFornecedor(){
        $model = new FornecedorModel();
        echo $model->DeleteFornecedor();
    }
}
$FornecedorController = new FornecedorController();
?>