<?php
include_once("../../Dao/BaseDao.php");
class MenuDao extends BaseDao
{
    Protected $tableName = en_menu;
    
    Protected $columns = array (dscMenu   => array("column" =>DSC_MENU, "typeColumn" =>I),codMenuPai   => array("column" =>COD_MENU_PAI, "typeColumn" =>D),nmeController   => array("column" =>NME_CONTROLLER, "typeColumn" =>I),nmeMethod   => array("column" =>NME_METHOD, "typeColumn" =>I),dscAtivo   => array("column" =>DSC_ATIVO, "typeColumn" =>I),indAtalho   => array("column" =>IND_ATALHO, "typeColumn" =>I),dscCaminhoImagem   => array("column" =>DSC_CAMINHO_IMAGEM, "typeColumn" =>I),);
    
    Protected $columnKey = array(codMenu=> array("column" =>COD_MENU, "typeColumn" => "I"));
    
    Public Function MenuDao(){
        $this->conect();
    }

    Public Function ListarMenu(){    
        return $this->MontarSelect();
    }

    Public Function UpdateMenu(){
        return $this->MontarUpdate();
    }

    Public Function InsertMenu($codLoja){
        return $this->MontarInsert($codLoja);
    }
}