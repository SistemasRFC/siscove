<?php
include_once("../BaseController.php");
include_once("../../Model/Deposito/DepositoModel.php");
class DepositoController extends BaseController
{
    Public Function DepositoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Deposito/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }

    Public Function ListarDepositos(){
        $model = new DepositoModel();
        echo $model->ListarDepositos();
    }

    Public Function ListarDepositosAtivos(){
        $model = new DepositoModel();
        echo $model->ListarDepositosAtivos();
    }

    Public Function ListarDepositosAtivosPorCliente(){
        $model = new DepositoModel();
        echo $model->ListarDepositosAtivosPorCliente();
    }

    Public Function ListarDepositosAtivosCombo(){
        $model = new DepositoModel();
        echo $model->ListarDepositosAtivosCombo();
    }

    Public Function AddDeposito(){    
        $model = new DepositoModel();
        echo $model->AddDeposito();
    }
    
    Public Function UpdateDeposito(){       
      $model = new DepositoModel();
      echo $model->UpdateDeposito();
    }
}
$DepositoController = new DepositoController();
?>