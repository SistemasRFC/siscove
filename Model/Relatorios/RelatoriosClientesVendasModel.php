<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/RelatoriosClientesVendasDao.php");
class RelatoriosClientesVendasModel extends BaseModel
{
    Public Function RelatoriosClientesVendasModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function QtdVendasPorCliente(){
        $dao = new RelatoriosClientesVendasDao();
        $lista = $dao->QtdVendasPorCliente($_SESSION['cod_cliente_final']);
        $lista = $lista[1];
        $total = count($lista);
        $i=0;
        $data = array();
        while($i<$total ) {
            $data[] = array(
                'qtdVendas' => $lista[$i]['QTD_VENDAS'],
                'dscCliente' => $lista[$i]['DSC_CLIENTE'],
                'dtaUltimaVenda' => $this->ConverteDataBanco($lista[$i]['DTA_ULTIMA_VENDA'])
            );
            $i++;
        }

        return json_encode($data);
    }
}
?>
