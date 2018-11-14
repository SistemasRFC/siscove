<?php
include_once("../BaseController.php");
include_once("../../Model/Perfil/PerfilModel.php");
class PerfilController extends BaseController
{
    function PerfilController(){
      $method = $_REQUEST['method'];
      $string =$method.'()';
      $method = "\$this->".$string.";";
      eval($method);
    }

    Private function ChamaView(){
        $params = array();        
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Private function ListarPerfil(){
        $model = new PerfilModel();
        echo $model->ListarPerfil();
    }

    Private function ListarPerfilRestrito(){
        $model = new PerfilModel();
        echo $model->ListarPerfilRestrito();
    }

    Private function ListarPerfilAtivo(){
        $model = new PerfilModel();
        echo $model->ListarPerfilAtivo();
    }

    Private function AddPerfil(){
        $PerfilModel = new PerfilModel();
        echo $PerfilModel->AddPerfil();
    }
    Private Function UpdatePerfil(){
        $PerfilModel = new PerfilModel();
        echo $PerfilModel->UpdatePerfil();
    }
    
    Public Function RetornaPerfilUsuarioLogado(){
        $PerfilModel = new PerfilModel();
        echo $PerfilModel->RetornaPerfilUsuarioLogado();   
    }
}
$PerfilController = new PerfilController();
?>