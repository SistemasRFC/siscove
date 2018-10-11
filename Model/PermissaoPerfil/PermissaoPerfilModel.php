<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/PermissaoPerfil/PermissaoPerfilDao.php");
class PermissaoPerfilModel extends BaseModel
{
    function PermissaoPerfilModel(){
        ob_start();
        session_start();
    }

    function ListarPerfil(){
        $dao = new PermissaoPerfilDao();
        return $dao->ListarPerfil();
    }

    function ListarPermissoes($json=true){
        $dao = new PermissaoPerfilDao();
        if ($json){
            return json_encode($dao->ListarPermissoes());
        }else{
            return $dao->ListarPermissoes();
        }
    }

    function AtualizaPermissoes(){
        $dao = new PermissaoPerfilDao();        
        $dao->RemovePermissoes();
        $array = explode("|", $_POST['C']);
        for ($i=0;$i<count($array)-1;$i++){
            $registro=explode(';',$array[$i]);            
            if ($registro[1]=='S'){
                $atualizado = $dao->AddPermissaoPerfil($registro[0]);
            }
        }
        return json_encode($atualizado);
    }
}
?>
