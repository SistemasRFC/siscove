<?
include_once("../../Dao/BaseDao.php");
class PermissaoDao extends BaseDao
{
    function PermissaoDao(){
    }

    function ListarPerfil(){
        $sql_lista = "SELECT COD_PERFIL_W, DSC_PERFIL_W FROM SE_PERFIL";
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function ListarMenus(){        
        try{
            $sql_lista = "
            SELECT M.DSC_MENU_W, M.COD_MENU_W,
                   MP.DSC_MENU_W AS DSC_MENU_PAI,
                   (SELECT DSC_PERFIL_W
                      FROM SE_PERFIL P
                     INNER JOIN SE_MENU_PERFIL MP
                        ON P.COD_PERFIL_W = MP.COD_PERFIL_W
                     WHERE MP.COD_MENU_W = M.COD_MENU_W
                       AND P.COD_PERFIL_W = ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT).") AS PERFIL
              FROM SE_MENU M
              LEFT JOIN SE_MENU MP
                ON M.COD_MENU_PAI_W = MP.COD_MENU_W
             WHERE M.IND_MENU_ATIVO_W='S'
	     ORDER BY DSC_MENU_PAI, M.DSC_MENU_W";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }

    Function AtualizaPermissoes(){        
        try{
            $sql_lista = "
            SELECT M.DSC_MENU_W, M.COD_MENU_W,
                   (SELECT DSC_PERFIL_W
                      FROM SE_PERFIL P
                     INNER JOIN SE_MENU_PERFIL MP
                        ON P.COD_PERFIL_W = MP.COD_PERFIL_W
                     WHERE MP.COD_MENU_W = M.COD_MENU_W
                       AND P.COD_PERFIL_W = ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT).") AS PERFIL
              FROM SE_MENU M
             WHERE IND_MENU_ATIVO_W='S'";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;

    }

    function RemovePermissoes($codMenu){        
        $sql_lista = "
            DELETE FROM SE_MENU_PERFIL
             WHERE COD_PERFIL_W = ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT);
        if ($codMenu!=0){
            $sql_lista .=  " AND COD_MENU_W = ".$codMenu;
        }        
        $result = $this->insertDB("$sql_lista");
        return $result;
    }

    function AddPermissao($codMenu){        
        $insert_login = "INSERT INTO SE_MENU_PERFIL
                          VALUES ('".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT)."','".$codMenu."')";
        return $this->insertDB("$insert_login");
    }
}
?>
