<?php
include_once("../../Dao/BaseDao.php");
class TipoContaDao extends BaseDao
{
    Public Function TipoContaDao(){
        $this->conect();
    }
    
    Public Function ListarTipoConta(){
        $sql_lista = "SELECT COD_TIPO_CONTA,
                                 DSC_TIPO_CONTA,
                                 IND_ATIVO
                            FROM EN_TIPO_CONTA ORDER BY DSC_TIPO_CONTA";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarTipoContaAtivoPesquisa(){
        $sql_lista = "SELECT -1 AS COD_TIPO_CONTA,
                             'TODOS' AS DSC_TIPO_CONTA
                      UNION
                      (SELECT COD_TIPO_CONTA,
                                 DSC_TIPO_CONTA
                            FROM EN_TIPO_CONTA
                           WHERE IND_ATIVO = 'S' ORDER BY DSC_TIPO_CONTA)";
        return $this->selectDB("$sql_lista", false);
    } 
    
    Public Function ListarTipoContaAtivo(){
        $sql_lista = "SELECT -1 AS COD_TIPO_CONTA,
                             'Selecione' AS DSC_TIPO_CONTA
                      UNION
                      (SELECT COD_TIPO_CONTA,
                                 DSC_TIPO_CONTA
                            FROM EN_TIPO_CONTA
                           WHERE IND_ATIVO = 'S' ORDER BY DSC_TIPO_CONTA)";
        return $this->selectDB("$sql_lista", false);
    }   

    Public Function AddTipoConta($codClienteFinal){
        $sql_lista = "
        INSERT INTO EN_TIPO_CONTA(COD_TIPO_CONTA, DSC_TIPO_CONTA, IND_ATIVO)
        VALUES(".$this->CatchUltimoCodigo('EN_TIPO_CONTA', 'COD_TIPO_CONTA').",
                                           '".filter_input(INPUT_POST, 'dscTipoConta', FILTER_SANITIZE_STRING)."',
                                           '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."')";
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    Public Function UpdateTipoConta(){
        $sql_lista = 
         "UPDATE EN_TIPO_CONTA SET DSC_TIPO_CONTA='".filter_input(INPUT_POST, 'dscTipoConta', FILTER_SANITIZE_STRING)."',
                                     IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."'
           WHERE COD_TIPO_CONTA = ".filter_input(INPUT_POST, 'codTipoConta', FILTER_SANITIZE_STRING);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }
}
?>
