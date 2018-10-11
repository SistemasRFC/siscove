<?php
include_once("../BaseController.php");
include_once("../../Model/Seguranca/PerfilModel.php");
class PerfilController extends BaseController
{
  function PerfilController(){
    $method = $_REQUEST['method'];
    $string =$method.'()';
    $method = "\$this->".$string.";";
    eval($method);
  }

  function ChamaView(){
    $params = array();    
    $view = $this->getPath()."/View/Seguranca/".str_replace("Controller", "View", get_class($this)).".php";
    echo ($this->gen_redirect_and_form($view, $params));
  }

  function ListarPerfil(){
    $model = new PerfilModel();
    echo $model->ListarPerfil();
  }

  function ListarPerfilRestrito(){
    $model = new PerfilModel();
    echo $model->ListarPerfilRestrito();
  }

  function ListarPerfilAtivo(){
    $model = new PerfilModel();
    echo $model->ListarPerfilAtivo();
  }

  function ListarPerfilAtivoCombo(){
    $model = new PerfilModel();
    echo $model->ListarPerfilAtivoCombo();
  }

  function AddPerfil(){
    $PerfilModel = new PerfilModel();
    echo $PerfilModel->AddPerfil();
    
  }
  function UpdatePerfil(){
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