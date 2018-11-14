<?php

include_once("../../Dao/BaseDao.php");

class MontaFileDao extends BaseDao {

    function MontaFileDao() {
        $this->conect();
    }

    function ListarTabelas() {
        $sql_lista = "SELECT TABLE_NAME AS NME_TABELA 
                        FROM INFORMATION_SCHEMA.TABLES 
                       WHERE TABLE_SCHEMA = 'siscove' ";
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function ListarColunas() {
        $sql_lista = "SHOW COLUMNS FROM " . filter_input(INPUT_POST, 'dscTabela', FILTER_SANITIZE_STRING);
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

}

?>