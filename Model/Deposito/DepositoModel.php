<?php
include_once ("../../Model/BaseModel.php");
include_once("../../Dao/Deposito/DepositoDao.php");
class DepositoModel extends BaseModel
{
    Public Function DepositoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarDepositos($Json=true){
        $dao = new DepositoDao();
        $lista = $dao->ListarDepositos($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO', 'ATIVO');
            }
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarDepositosAtivos($Json=true){
        $dao = new DepositoDao();
        $lista = $dao->ListarDepositosAtivos($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarDepositosAtivosPorCliente($Json=true){
        $dao = new DepositoDao();
        $lista = $dao->ListarDepositosAtivosPorCliente($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarDepositosAtivosCombo($Json=true){
        $dao = new DepositoDao();
        $lista = $dao->ListarDepositosAtivos($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista[1]);
        }else{
            return $lista[1];
        }
    }
    
    Public Function AddDeposito($codClienteFinal=null){
        if ($codClienteFinal==null){
            $codClienteFinal = $_SESSION['cod_cliente_final'];
        }
        $dao = new DepositoDao();
        $result = $dao->VerificaNomeDeposito($_SESSION['cod_cliente_final']);
        if ($result[0]){
            if ($result[1][0]['QTD']>0){
                $result[0]=false;
                $result[1]="Este depósito já foi cadastrado!";
            }else{
                $result = $dao->AddDeposito($codClienteFinal,
                                             filter_input(INPUT_POST, 'dscDeposito', FILTER_SANITIZE_STRING),
                                             filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING));
            }
        }
        return json_encode($result);
    }

    Public Function UpdateDeposito(){
        $dao = new DepositoDao();
        $result = $dao->VerificaNomeDeposito($_SESSION['cod_cliente_final']);
        if ($result[0]){
            if ($result[1][0]['QTD']>0){
                $result[0]=false;
                $result[1]="Este depósito já foi cadastrado!";
            }else{
                $result = $dao->UpdateDeposito();
            }
        }
        return json_encode($result);
    }
}
?>
