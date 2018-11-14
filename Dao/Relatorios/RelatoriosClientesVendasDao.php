<?php
include_once("../../Dao/BaseDao.php");
class RelatoriosClientesVendasDao extends BaseDao
{
    Public Function RelatoriosClientesVendasDao(){
        $this->conect();
    }

    Public Function QtdVendasPorCliente($codClienteFinal){
        $sql_lista = "SELECT COUNT(V.COD_VENDA) AS QTD_VENDAS,
                             COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                             (SELECT MAX(DTA_VENDA)
                                FROM EN_VENDA
                               WHERE COD_CLIENTE = C.COD_CLIENTE) AS DTA_ULTIMA_VENDA
                        FROM EN_VENDA V
                       INNER JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND V.NRO_STATUS_VENDA = 'F'
                       GROUP BY C.DSC_CLIENTE
                       ORDER BY COUNT(V.COD_VENDA) DESC";
        return $this->selectDB("$sql_lista", false);
    }
}
?>
