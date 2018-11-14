<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Servico/ServicoDao.php");
class ServicoModel extends BaseModel
{
    Public Function ServicoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarServico($Json=true){
        $dao = new ServicoDao();
        $lista = $dao->ListarServico($_SESSION['cod_cliente_final']);
        $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO|IND_COMISSAO_GERENCIA', 'ATIVO|COMISSAO_GERENCIA');
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PRODUTO|VLR_PORCENTAGEM|VLR_MINIMO');
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarServicosAtivos($Json=true){
        $dao = new ServicoDao();
        $lista = $dao->ListarServicosAtivos($_SESSION['cod_cliente_final']);
        $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_COMISSAO_GERENCIA', 'COMISSAO_GERENCIA');
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }

    }

    Public Function AddServico(){
        $dao = new ServicoDao();
        return json_encode($dao->AddServico($_SESSION['cod_cliente_final']));
    }

    Public Function UpdateServico(){
        $dao = new ServicoDao();
        return json_encode($dao->UpdateServico());
    }
}
?>
