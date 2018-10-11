<?php
include_once('../../Model/BaseModel.php');
include_once("../../Dao/Veiculo/VeiculoDao.php");
class VeiculoModel extends BaseModel
{
    Public Function VeiculoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarVeiculoGrid($Json=true){
        $dao = new VeiculoDao();
        $lista = $dao->ListarVeiculoGrid();
        if ($lista[0]){
            $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO', 'ATIVO');
        }
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarVeiculosAutoComplete($Json=true){
        $dao = new VeiculoDao();
        $lista = $dao->ListarVeiculosAutoComplete();
        if ($Json){
            return json_encode($lista[1]);
        }else{
            return $lista[1];
        }        
        
    }
    
    Public Function AddVeiculo($Json=true){
        $dao = new VeiculoDao();
        $codVeiculo = $dao->VerificaNomeVeiculo();
        if ($codVeiculo[0]){
            if ($codVeiculo[1][0]['COD_VEICULO']>0){
                $result[0]=false;
                $result[1]='Nome de veículo já cadastrado!';
            }else{
                $result = $dao->AddVeiculo();
            }
        }
        return json_encode($result); 
    }

    Public Function UpdateVeiculo($Json=true){
        $dao = new VeiculoDao();
        $codVeiculo = $dao->VerificaNomeVeiculo();
        if ($codVeiculo[0]){
            if ($codVeiculo[1][0]['COD_VEICULO']>0){
                $result[0]=false;
                $result[1]='Nome de veículo já cadastrado!';
            }else{
                $result = $dao->UpdateVeiculo();
            }
        }
        return json_encode($result);
    }
}
?>
