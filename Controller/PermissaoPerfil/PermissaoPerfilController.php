<?php
include_once("../BaseController.php");
include_once("../../Model/PermissaoPerfil/PermissaoPerfilModel.php");
class PermissaoPerfilController extends BaseController
{
  function PermissaoPerfilController(){
    $method = $_REQUEST['method'];
    $string =$method.'()';
    $method = "\$this->".$string.";";
    eval($method);

  }
  /**
   * Redireciona para a view indicada
   */
  function ChamaView(){
    $params = array();        
    echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
  }

  Public Function ListarPermissoes(){
    $model = new PermissaoPerfilModel();
    echo $model->ListarPermissoes();
  }
  function AtualizaPermissoes(){
    $model = new PermissaoPerfilModel();
    echo $model->AtualizaPermissoes();
  }
}
$PermissaoPerfilController = new PermissaoPerfilController();
?>