<?php
include_once("../BaseController.php");
include_once("../../Model/Funcionario/FuncionarioModel.php");
class FuncionarioController extends BaseController
{
    Public Function FuncionarioController(){        
      eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Funcionario/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);   
    }

    Public Function ListarFuncionarioGrid(){
        $model = new FuncionarioModel();
        echo $model->ListarFuncionarioGrid();
    }
    
    Public Function ListarFuncionariosAtivos(){
        $model = new FuncionarioModel();
        echo $model->ListarFuncionariosAtivos();
    }
    
    Public Function ListarVendedoresAtivos(){
        $model = new FuncionarioModel();
        echo $model->ListarVendedoresAtivos();
    }

    Public Function AddFuncionario(){
        $funcionarioModel = new FuncionarioModel();
        echo $funcionarioModel->AddFuncionario();
    }
    Public Function UpdateFuncionario(){
        $funcionarioModel = new FuncionarioModel();
        echo $funcionarioModel->UpdateFuncionario();
    }  
}
$FuncionarioController = new FuncionarioController();
?>