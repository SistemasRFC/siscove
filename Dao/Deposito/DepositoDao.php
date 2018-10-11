<?php
include_once("../../Dao/BaseDao.php");
class DepositoDao extends BaseDao
{
    Public Function DepositoDao(){
        $this->conect();
    }

    /**
     *retorna lista de depósitos
     * @param type $codClienteFinal
     * @return type 
     */
    Public Function ListarDepositos($codClienteFinal){
        $sql_lista = "SELECT COD_DEPOSITO,
                                 DSC_DEPOSITO,
                                 IND_ATIVO
                            FROM EN_DEPOSITO
                           WHERE COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql_lista", false);
    }  
    
    Public Function ListarDepositosAtivos($codClienteFinal){
        $sql_lista = "SELECT COD_DEPOSITO,
                                 DSC_DEPOSITO,
                                 IND_ATIVO
                            FROM EN_DEPOSITO
                           WHERE COD_CLIENTE_FINAL = $codClienteFinal 
                             AND IND_ATIVO='S'";
        return $this->selectDB("$sql_lista", false);
    }  
    
    Public Function ListarDepositosAtivosPorCliente(){
        $sql_lista = "SELECT COD_DEPOSITO,
                                 DSC_DEPOSITO,
                                 IND_ATIVO
                            FROM EN_DEPOSITO
                           WHERE COD_CLIENTE_FINAL = ".filter_input(INPUT_POST, 'codCliente', FILTER_SANITIZE_NUMBER_INT)." 
                             AND IND_ATIVO='S'";
        return $this->selectDB("$sql_lista", false);
    }    

    Public Function AddDeposito($codClienteFinal, $dscDeposito, $indAtivo){
        $codDeposito = $this->CatchUltimoCodigo('EN_DEPOSITO', 'COD_DEPOSITO');
        $sql_lista = "
        INSERT INTO EN_DEPOSITO VALUES(".$codDeposito.",
                                      '".$dscDeposito."', 
                                      $codClienteFinal, 
                                      '".$indAtivo."')";
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    Public Function UpdateDeposito(){
        $sql_lista = 
         "UPDATE EN_DEPOSITO 
             SET DSC_DEPOSITO='".filter_input(INPUT_POST, 'dscDeposito', FILTER_SANITIZE_STRING)."',
                 IND_ATIVO='".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."'
           WHERE COD_DEPOSITO = ".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql_lista");
    } 
    
    Public Function VerificaNomeDeposito($codClienteFinal){
        $sql_lista = "SELECT COUNT(COD_DEPOSITO) AS QTD
                            FROM EN_DEPOSITO
                           WHERE COD_CLIENTE_FINAL = ".$codClienteFinal." 
                             AND DSC_DEPOSITO = '".filter_input(INPUT_POST, 'dscDeposito', FILTER_SANITIZE_STRING)."'
                             AND COD_DEPOSITO <> ".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_STRING)."
                             AND IND_ATIVO = 'S'";
        return $this->selectDB("$sql_lista", false);
    }
}
?>
