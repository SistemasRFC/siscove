<?php
include_once("../BaseController.php");
include_once("../../Model/PermissaoMenu/PermissaoMenuModel.php");
class PermissaoMenuController extends BaseController
{
  function PermissaoMenuController(){
    $method = $_REQUEST['method'];
    $string =$method.'()';
    $method = "\$this->".$string.";";
    eval($method);

  }
  /**
   * Redireciona para a view indicada
   */
  function ChamaView(){
    $model = new PermissaoMenuModel();
    $listaPerfil = $model->ListarPerfil();
    $listaMenus = $model->ListarMenus();
    if (!isset($_POST['codPerfil'])){
        $codPerfil=0;
    }else{
        $codPerfil=$_POST['codPerfil'];
    }
    $params = array('ListaPerfil' => urlencode(serialize($listaPerfil)),
                    'ListaMenus' => urlencode(serialize($listaMenus)),
                    'codPerfil' => urlencode(serialize($codPerfil)));
    echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));    
    //$view = $this->getPath()."/View/Seguranca/".str_replace("Controller", "View", get_class($this)).".php";
    //echo ($this->gen_redirect_and_form($view, $params));
  }

  Public Function ListarMenus(){
    $model = new PermissaoMenuModel();
    echo $model->ListarMenus(true);
  }
  function AtualizaPermissoes(){
    $model = new PermissaoMenuModel();
    echo $model->AtualizaPermissoes();
  }
}
$PermissaoMenuController = new PermissaoMenuController();
?>