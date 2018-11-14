<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Seguranca/UsuarioDao.php");
class UsuarioModel extends BaseModel
{
    function UsuarioModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    function ListarUsuario(){
        $dao = new UsuarioDao();        
        $lista = $dao->ListarUsuario($_SESSION['cod_perfil'], $_SESSION['cod_cliente_final']);    
        if ($lista[0]){
            if ($lista[1]!=null){
                $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO', 'ATIVO');
            }
        }
        return json_encode($lista);
    }
    
    function AddUsuario(){
        $dao = new UsuarioDao();
        return json_encode($dao->AddUsuario());
    }

    function UpdateUsuario(){
        $dao = new UsuarioDao();
        return json_encode($dao->UpdateUsuario());
    }

    function DeleteUsuario(){
        $dao = new UsuarioDao();
        return $dao->DeleteUsuario();
    }
    
    function AddLogin(){
        $dao = new UsuarioDao();        
        $result = $dao->AddLogin();
        return $result;
    }

    Public Function ReiniciarSenha(){
        $dao = new UsuarioDao();
        return json_encode($dao->ReiniciarSenha());
    }

    Public Function ResetaSenha(){
        $dao = new UsuarioDao();
        return json_encode($dao->ResetaSenha());
    } 

    Public Function RetornaPerfil(){
        $result[0] = true;
        $result[1] = $_SESSION['cod_perfil'];
        $result[2] = $_SESSION['cod_cliente_final'];
        return json_encode($result);
    } 
}
?>
