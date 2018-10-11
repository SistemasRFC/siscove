<?php
include_once("../../Dao/BaseDao.php");
class RelatoriosClientesDao extends BaseDao
{
    function RelatoriosClientesDao(){
        $this->conect();
    }

    function DadosCliente($codClienteFinal){
        try{
            $sql_lista = "
            SELECT COD_CLIENTE,
                   NRO_CPF,
		   DSC_CLIENTE,
		   NRO_TELEFONE_CONTATO,
		   NRO_TELEFONE_CELULAR
              FROM EN_CLIENTE
             WHERE COD_CLIENTE_FINAL = $codClienteFinal
             ORDER BY DSC_CLIENTE";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }

    function DadosVendas($codClienteFinal){
        try{
            $sql_lista = "
            SELECT DTA_VENDA,
                   CASE WHEN V.COD_VEICULO IS NULL THEN V.DSC_VEICULO ELSE VE.DSC_VEICULO END AS DSC_VEICULO,
                   NRO_PLACA,
                   C.COD_CLIENTE,
                   NRO_CPF,
		   DSC_CLIENTE,
		   NRO_TELEFONE_CONTATO,
		   NRO_TELEFONE_CELULAR
              FROM EN_VENDA V
             INNER JOIN EN_CLIENTE C
                ON V.COD_CLIENTE = C.COD_CLIENTE
              LEFT JOIN EN_VEICULOS VE
                ON V.COD_VEICULO = VE.COD_VEICULO
             WHERE NRO_STATUS_VENDA NOT IN ('C','O')
               AND C.COD_CLIENTE_FINAL = $codClienteFinal
             ORDER BY DSC_CLIENTE, DTA_VENDA";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }
}
?>
