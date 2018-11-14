<?php
include_once("../BaseController.php");
include_once("../../Model/Marca/MarcaModel.php");
class MarcaController extends BaseController
{
    Public Function MarcaController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $view = $this->getPath()."/View/Marca/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }

    Public Function ListarMarcas(){
        $model = new MarcaModel();
        echo $model->ListarMarcas();
    }

    Public Function ListarMarcasAtivas(){
        $model = new MarcaModel();
        echo $model->ListarMarcasAtivas();
    }

    Public Function AddMarca(){
        $model = new MarcaModel();
        echo $model->AddMarca();
    }
    
    Public Function UpdateMarca(){
        $model = new MarcaModel();
        echo $model->UpdateMarca();
    }
}
$MarcaController = new MarcaController();
?>