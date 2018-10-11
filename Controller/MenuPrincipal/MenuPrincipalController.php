<?php
include_once("../BaseController.php");
include_once("../../Model/MenuPrincipal/MenuPrincipalModel.php");
class MenuPrincipalController extends BaseController
{
  function MenuPrincipalController(){         
    eval("\$this->".BaseController::getMethod()."();");
  }
  
  /**
   * Verifica se o usuário é válido
   * @param type $pagina
   */
  function CarregaMenu(){
    $menuModel = new MenuPrincipalModel();
    //$menuModel->carregaMenu(0,$this->getPath());
    $menuModel->carregaAtalhos($this->getPath());
    $menuModel->carregaDadosUsuario();
    $params = array();
    echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
  }

    Public Function VerificaSessao(){
        ob_start();
        session_start();
        if (!isset($_SESSION['cod_usuario'])){
            echo json_encode(false);
        }else{
            echo json_encode(true);
        }
    }
    
    Public Function CarregaMenuNew(){
        $menuModel = new MenuPrincipalModel();
        echo $menuModel->CarregaMenuNew($this->getPath());
    }

    Public Function CarregaAtalhos(){
        $menuModel = new MenuPrincipalModel();
        echo $menuModel->CarregaAtalhos($this->getPath());
    }
}
$menuPrincipalController = new MenuPrincipalController();
?>