<?php
include_once("../BaseController.php");
include_once("../../Model/Veiculo/VeiculoModel.php");
class VeiculoController extends BaseController
{
    Public Function VeiculoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Veiculo/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }

    Public Function ListarVeiculosGrid(){
        $model = new VeiculoModel();
        echo $model->ListarVeiculoGrid();
    }

    Public Function ListarVeiculosAutoComplete(){
        $model = new VeiculoModel();
        echo $model->ListarVeiculosAutoComplete();
    }

    Public Function AddVeiculo(){
        $model = new VeiculoModel();
        echo $model->AddVeiculo();
    }

    Public Function UpdateVeiculo(){
        $model = new VeiculoModel();
        echo $model->UpdateVeiculo();
    }
}
$VeiculoController = new VeiculoController();
?>