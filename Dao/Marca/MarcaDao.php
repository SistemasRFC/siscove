<?php
include_once("../../Dao/BaseDao.php");
class MarcaDao extends BaseDao
{
    Public Function MarcaDao(){
        $this->conect();
    }
    
    Public Function ListarMarcas($codClienteFinal){
        $sql_lista = "SELECT COD_MARCA,
                             DSC_MARCA,
                             IND_ATIVA
                        FROM EN_MARCA
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal
                       ORDER BY DSC_MARCA";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarMarcasAtivas($codClienteFinal){
        $sql_lista = "SELECT COD_MARCA,
                             DSC_MARCA
                        FROM EN_MARCA
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal 
                         AND IND_ATIVA = 'S'
                       ORDER BY DSC_MARCA";
        return $this->selectDB("$sql_lista", false);
    }    

    Public Function AddMarca($codClienteFinal){
        $sql_lista = "
        INSERT INTO EN_MARCA VALUES(".$this->CatchUltimoCodigo('EN_MARCA', 'COD_MARCA').",
                                    '".filter_input(INPUT_POST, 'dscMarca', FILTER_SANITIZE_STRING)."',
                                     ".$codClienteFinal.",
                                    '".filter_input(INPUT_POST, 'indAtiva', FILTER_SANITIZE_STRING)."')";
        return $this->insertDB("$sql_lista");
    }

    Public Function UpdateMarca(){
        $sql_lista = 
         "UPDATE EN_MARCA SET DSC_MARCA='".filter_input(INPUT_POST, 'dscMarca', FILTER_SANITIZE_STRING)."',
                              IND_ATIVA='".filter_input(INPUT_POST, 'indAtiva', FILTER_SANITIZE_STRING)."'
           WHERE COD_MARCA = ".filter_input(INPUT_POST, 'codMarca', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql_lista");
    }
}
?>
