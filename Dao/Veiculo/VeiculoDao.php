<?php
include_once("../../Dao/BaseDao.php");
class VeiculoDao extends BaseDao
{
    function VeiculoDao(){
        $this->conect();
    }

    function ListarVeiculoGrid(){
        $sql_lista = "SELECT COD_VEICULO,
                                 DSC_VEICULO,
                                 IND_ATIVO
                            FROM EN_VEICULOS";
        return $this->selectDB("$sql_lista", false);
    }

    function ListarVeiculosAutoComplete(){
        $sql_lista = "SELECT COD_VEICULO as id,
                                 DSC_VEICULO as value
                            FROM EN_VEICULOS
                           WHERE DSC_VEICULO LIKE '".filter_input(INPUT_POST, 'term', FILTER_SANITIZE_STRING)."%'
                             AND IND_ATIVO = 'S'";
        return $this->selectDB("$sql_lista", false);
    }    

    function AddVeiculo(){
        $sql_lista = "
        INSERT INTO EN_VEICULOS VALUES(".$this->CatchUltimoCodigo('EN_VEICULOS', 'COD_VEICULO').",
                                      '".filter_input(INPUT_POST, 'dscVeiculo', FILTER_SANITIZE_STRING)."',
                                      '".filter_input(INPUT_POST, 'indVeiculoAtivo', FILTER_SANITIZE_STRING)."')";
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    function UpdateVeiculo(){
        $sql_lista = 
         "UPDATE EN_VEICULOS SET DSC_VEICULO='".filter_input(INPUT_POST, 'dscVeiculo', FILTER_SANITIZE_STRING)."',
                                 IND_ATIVO = '".filter_input(INPUT_POST, 'indVeiculoAtivo', FILTER_SANITIZE_STRING)."'
           WHERE COD_VEICULO = ".filter_input(INPUT_POST, 'codVeiculo', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    function VerificaNomeVeiculo(){
        $codVeiculo = filter_input(INPUT_POST, 'codVeiculo', FILTER_SANITIZE_NUMBER_INT);
        if ($codVeiculo==''){
            $codVeiculo=0;
        }
        $sql_lista = "SELECT COALESCE(COD_VEICULO,0) AS COD_VEICULO
                        FROM EN_VEICULOS
                       WHERE DSC_VEICULO = '".filter_input(INPUT_POST, 'dscVeiculo', FILTER_SANITIZE_STRING)."'
                         AND COD_VEICULO <> ".$codVeiculo;        
        return $this->selectDB("$sql_lista", false);
    } 

}
?>
