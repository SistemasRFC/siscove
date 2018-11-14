<?php
include_once("../BaseController.php");
include_once("../../Model/Login/LoginModel.php");
class LoginController extends BaseController
{
    function LoginController(){        
        eval("\$this->".BaseController::getMethod()."();");
    }
    /**
     * Verifica se o usuário é válido
     * @param type $pagina 
     */
    function Logar(){
        $model = new LoginModel();        
        $logar = $model->Logar();
        echo $logar;
    }

  function AlteraSenha(){
     $model = new LoginModel();
     if ($model->AlteraSenha()){
        header("Location: ../../Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu");
    }else{
        header("Location: ../../index.php");
    }
  }
  function Logoff(){
      header("Location: ../../index.php");
  }
}
$loginController = new LoginController();
?>