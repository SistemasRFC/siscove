<?
include_once("../../Dao/BaseDao.php");
class CadastroMenuDao extends BaseDao
{
    function CadastroMenuDao(){
    }

    /**
     * Retorna uma lista de menus
     * @return array
     */
    function ListaMenus(){
        try{
            $sql_lista = "

            SELECT COD_MENU_W,
                   DSC_MENU_W
              FROM SE_MENU
             WHERE COD_MENU_PAI_W > -1
            UNION
            SELECT '0' AS COD_MENU_W,
                   'Sem Pai' AS DSC_MENU_W
            ORDER BY DSC_MENU_W";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }

    function ListarMenusAutoComplete($parametro){
        try{
            $sql_lista = "
            SELECT COD_MENU_W,
                   DSC_MENU_W,
                   NME_CONTROLLER,
                   NME_METHOD,
                   IND_MENU_ATIVO_W,
                   COD_MENU_PAI_W,
                   COALESCE(IND_ATALHO,'N') AS IND_ATALHO,
                   COALESCE(DSC_CAMINHO_IMAGEM, '') AS DSC_CAMINHO_IMAGEM,
                   (SELECT COUNT(*)
                      FROM SE_MENU
                     WHERE COD_MENU_W>0
                       AND COD_MENU_PAI_W = M.COD_MENU_W) AS QTD
              FROM SE_MENU M
             WHERE COD_MENU_PAI_W >=0
               AND DSC_MENU_W LIKE '$parametro%'";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }

    Public Function ListarMenusGrid(){
        try{
            $sql_lista = "
            SELECT COD_MENU_W,
                   DSC_MENU_W,
                   NME_CONTROLLER,
                   NME_METHOD,
                   IND_MENU_ATIVO_W,
                   COD_MENU_PAI_W,
                   COALESCE(IND_ATALHO,'N') AS IND_ATALHO,
                   COALESCE(DSC_CAMINHO_IMAGEM, '') AS DSC_CAMINHO_IMAGEM,
                   (SELECT COUNT(*)
                      FROM SE_MENU
                     WHERE COD_MENU_W>0
                       AND COD_MENU_PAI_W = M.COD_MENU_W) AS QTD
              FROM SE_MENU M
             WHERE COD_MENU_PAI_W >=0";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }

    function AddMenu(){        
        $sql_lista = "
        INSERT INTO SE_MENU(COD_MENU_W, DSC_MENU_W, NME_CONTROLLER, IND_MENU_ATIVO_W, COD_MENU_PAI_W, 
                            NME_METHOD, DSC_CAMINHO_IMAGEM, IND_ATALHO) 
                    VALUES (".$this->CatchUltimoCodigo('SE_MENU', 'COD_MENU_W').", "
                             ."'".filter_input(INPUT_POST, 'dscMenu', FILTER_SANITIZE_MAGIC_QUOTES)."', ".
                             "'".filter_input(INPUT_POST,'nmeController',FILTER_SANITIZE_MAGIC_QUOTES)."', ".
                             "'".filter_input(INPUT_POST,'indAtivo',FILTER_SANITIZE_MAGIC_QUOTES)."', ".
                             filter_input(INPUT_POST,'codMenuPai',FILTER_SANITIZE_NUMBER_INT).", ".
                             "'".filter_input(INPUT_POST,'nmeMethod',FILTER_SANITIZE_MAGIC_QUOTES)."', ".
                             "'".filter_input(INPUT_POST,'dscCaminhoImagem',FILTER_SANITIZE_MAGIC_QUOTES)."', ".
                             "'".filter_input(INPUT_POST,'indAtalho',FILTER_SANITIZE_MAGIC_QUOTES)."') ";
        $result = $this->insertDB("$sql_lista");
        return $result;
        
    }

    function UpdateMenu(){        
        $sql_lista = "
        UPDATE SE_MENU SET DSC_MENU_W ='".filter_input(INPUT_POST, 'dscMenu', FILTER_SANITIZE_MAGIC_QUOTES)."',
                           NME_CONTROLLER = '".filter_input(INPUT_POST,'nmeController',FILTER_SANITIZE_MAGIC_QUOTES)."',
                           IND_MENU_ATIVO_W = '".filter_input(INPUT_POST,'indAtivo',FILTER_SANITIZE_MAGIC_QUOTES)."',
                           COD_MENU_PAI_W = ".filter_input(INPUT_POST,'codMenuPai',FILTER_SANITIZE_NUMBER_INT).",
                           NME_METHOD = '".filter_input(INPUT_POST,'nmeMethod',FILTER_SANITIZE_MAGIC_QUOTES)."',
                           DSC_CAMINHO_IMAGEM = '".filter_input(INPUT_POST,'dscCaminhoImagem',FILTER_SANITIZE_MAGIC_QUOTES)."',
                           IND_ATALHO = '".filter_input(INPUT_POST,'indAtalho',FILTER_SANITIZE_MAGIC_QUOTES)."'
         WHERE COD_MENU_W = ".filter_input(INPUT_POST,'codMenu',FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista", false);
        return $result;

    }

    function DeleteMenu(){       
        $sql_lista = "
        DELETE FROM SE_MENU
         WHERE COD_MENU_W = ".filter_input(INPUT_POST,'codMenu',FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista", false);
        return $result;

    }

}
?>
