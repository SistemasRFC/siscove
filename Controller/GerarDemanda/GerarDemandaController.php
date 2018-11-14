<?php
include_once("../BaseController.php");
class GerarDemandaController extends BaseController
{
    Public Function GerarDemandaController(){        
      eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
//        echo 123; die;
        $view = $this->getPath()."/View/GerarDemanda/".str_replace("Controller", "View", get_class($this)).".php";
        header("Location: ".$view);
    }
}
$GerarDemandaController = new GerarDemandaController();
?>