<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/ClienteFinal/ClienteFinalDao.php");
include_once("../../Dao/Deposito/DepositoDao.php");
class ClienteFinalModel extends BaseModel
{
    Public Function ClienteFinalModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }    
    
    Public Function ListarClienteFinal($Json=true){
        $clienteFinalDao = new ClienteFinalDao();
        $lista = $clienteFinalDao->ListarClienteFinal();
        for ($i=0;$i<count($lista);$i++){
            $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO' , 'ATIVO');
        }
        if ($Json){
            $lista = json_encode($lista);
        }
        return $lista;
    }    
    
    Public Function ListarClienteFinalAtivo($Json=true){
        $clienteFinalDao = new ClienteFinalDao();
        $lista = $clienteFinalDao->ListarClienteFinalAtivo();
        if ($Json){
            $lista = json_encode($lista);
        }
        return $lista;
    }
    
    Public Function UpdateCliente($Json=true){
        $clienteFinalDao = new ClienteFinalDao();
        $lista = $clienteFinalDao->UpdateCliente();
        if ($Json){
            $lista = json_encode($lista);
        }
        return $lista;
    } 
    
    Public Function AddCliente($Json=true){
        $depositoDao = new DepositoDao();
        $clienteFinalDao = new ClienteFinalDao();
        $lista = $clienteFinalDao->AddCliente();
        if ($lista[0]){
            $_POST['dscDeposito'] = 'Central';
            $_POST['indAtivo'] = 'S';
            $depositoDao->AddDeposito($lista[2], 'Central', 'S');
        }
        if ($Json){
            $lista = json_encode($lista);
        }
        return $lista;
    }
    
    Public Function DeleteCliente($Json=true){
        $clienteFinalDao = new ClienteFinalDao();
        $lista = $clienteFinalDao->DeleteCliente();
        if ($Json){
            $lista = json_encode($lista);
        }
        return $lista;
    }
}
?>
