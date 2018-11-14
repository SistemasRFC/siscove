<?php 
include_once("../BaseController.php");
include_once("../../Model/Usuario/UsuarioModel.php");
class UsuarioController extends BaseController
{
    function UsuarioController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Private function ChamaView(){
        $params = array();        
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));  
    }

    Private function ListarUsuario(){
        $model = new UsuarioModel();
        echo $model->ListarUsuario();
    }
    
    Private Function ListaDadosUsuario(){
        $model = new UsuarioModel();
        echo $model->ListaDadosUsuario();        
    }
    Private function AddUsuario(){
        $UsuarioModel = new UsuarioModel();
        echo $UsuarioModel->AddUsuario();
    }
    Private function UpdateUsuario(){
        $UsuarioModel = new UsuarioModel();
        echo $UsuarioModel->UpdateUsuario();  
    }

    Private function DeleteUsuario(){
        $UsuarioModel = new UsuarioModel();
        echo $UsuarioModel->UpdateUsuario();
    }

    Private function AddLogin(){
        $UsuarioModel = new UsuarioModel();
        echo $UsuarioModel->AddLogin();
    }

    Public Function ReiniciarSenha(){
        $UsuarioModel = new UsuarioModel();
        echo $UsuarioModel->ReiniciarSenha();
    }

    Public Function ResetaSenha(){
        $UsuarioModel = new UsuarioModel();
        echo $UsuarioModel->ResetaSenha();
    }  
}
$UsuarioController = new UsuarioController();
?>