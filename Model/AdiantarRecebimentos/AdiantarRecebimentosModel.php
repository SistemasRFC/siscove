<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/AdiantarRecebimentos/AdiantarRecebimentosDao.php");
class AdiantarRecebimentosModel extends BaseModel
{
    Public Function AdiantarRecebimentosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarAdiantarRecebimentos($Json=true){
        $dao = new AdiantarRecebimentosDao();
        $lista = $dao->ListarAdiantarRecebimentos($_SESSION['cod_cliente_final']);
        if ($lista[0]){                        
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO|DTA_VENDA');
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
    
    Public Function AddAdiantarRecebimentos(){
        $dao = new AdiantarRecebimentosDao();    
        $nroSequencial = filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_STRING);        
        $valores = explode('|', $nroSequencial);
        $values = ' VALUES ';
        for ($i=0;$i<count($valores)-1;$i++){
            $valor = explode(';', $valores[$i]);
            $valor[1] = str_replace('.', '', $valor[1]);
            $valor[1] = str_replace(',', '.', $valor[1]);
            $values .= "(".$valor[0].", NOW(), ".$valor[1].", '', ".$_SESSION['cod_cliente_final']."),";
        }
        $values = substr($values, 0, strlen($values)-1).';';
        return json_encode($dao->AddAdiantarRecebimentos($values));
    }
}
?>
