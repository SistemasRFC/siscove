<?php
include_once("../../Dao/BaseDao.php");
class PermissaoPerfilDao extends BaseDao
{
    function PermissaoPerfilDao(){
        $this->conect();
    }

    Function ListarPermissoes(){        
        try{
            $sql_lista = "
            SELECT COD_PERFIL_W,
                   DSC_PERFIL_W,
                   (SELECT DSC_PERFIL_W
                      FROM SE_PERFIL PI
                     INNER JOIN RE_PERMISSAO_PERFIL PP
                        ON PI.COD_PERFIL_W = PP.COD_PERFIL_ACESSO
                     WHERE PP.COD_PERFIL_ACESSO = P.COD_PERFIL_W
                       AND PP.COD_PERFIL = ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT).") AS PERFIL
              FROM SE_PERFIL P
             WHERE IND_ATIVO='S'";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;

    }

    function RemovePermissoes(){
        
        $sql_lista = "
            DELETE FROM RE_PERMISSAO_PERFIL
             WHERE COD_PERFIL = ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT);   
        $result = $this->insertDB("$sql_lista");
        return $result;
    }

    function AddPermissaoPerfil($codPerfil){        
        $insert_login = "INSERT INTO RE_PERMISSAO_PERFIL
                          VALUES ('".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT)."','".$codPerfil."')";
        return $this->insertDB("$insert_login");
    }
}
?>
