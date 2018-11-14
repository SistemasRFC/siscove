<?php
include_once("../../Dao/BaseDao.php");
class MenuDao extends BaseDao
{
    Protected $tableName = en_menu;
    
    Protected $columns = array (dscMenu   => array("column" =>DSC_MENU, "typeColumn" =>"varchar(50)"),codMenuPai   => array("column" =>COD_MENU_PAI, "typeColumn" =>"I"),nmeController   => array("column" =>NME_CONTROLLER, "typeColumn" =>"varchar(100)"),nmeMethod   => array("column" =>NME_METHOD, "typeColumn" =>"varchar(100)"),dscAtivo   => array("column" =>DSC_ATIVO, "typeColumn" =>"enum('S','N')"),indAtalho   => array("column" =>IND_ATALHO, "typeColumn" =>"enum('S','N')"),dscCaminhoImagem   => array("column" =>DSC_CAMINHO_IMAGEM, "typeColumn" =>"varchar(100)"),);
    
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