<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Cliente/ClienteDao.php");
class ClienteModel extends BaseModel
{
    Public Function ClienteModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarClienteGrid($json=true){
        $dao = new ClienteDao();
        $lista = $dao->ListarClienteGrid($_SESSION['cod_cliente_final']);
        if ($json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarClienteAutoComplete($json=true){
        $dao = new ClienteDao();
        $lista = $dao->ListarClienteAutoComplete($_SESSION['cod_cliente_final']);
        if ($json){
            return json_encode($lista[1]);
        }else{
            return $lista;
        }
    }

    Public Function ListarClienteCpfAutoComplete($json=true){
        $dao = new ClienteDao();
        $lista = $dao->ListarClienteCpfAutoComplete($_SESSION['cod_cliente_final']);
        if ($json){
            return json_encode($lista[1]);
        }else{
            return $lista;
        }
    }

    Public Function ListarEstados($json=true){
        $dao = new ClienteDao();
        $lista = $dao->ListarEstados();
        if ($json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function CarregaDadosCliente($json=true){
        $dao = new ClienteDao();
        $lista = $dao->CarregaDadosCliente();
        if ($json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function AddCliente(){
        $dao = new ClienteDao();
        $nroCpf = filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_STRING);
        if (trim($nroCpf)!=''){
            if (BaseModel::validaCPF($nroCpf)){
                $codClienteCPF = $dao->VerificaCPF();
                if ($codClienteCPF[0]){
                    if ($codClienteCPF[1][0]['COD_CLIENTE']>0){
                        $result[0]=false;
                        $result[1]='CPF utilizado em outro cadastro!';
                    }else{
                        $result = $dao->AddCliente($_SESSION['cod_cliente_final']);
                    }
                }else{
                    $result = $codClienteCPF;
                }
            }else{
                $result[0]=false;
                $result[1]='CPF inválido!';
            }
        }else{
            $result = $dao->AddCliente($_SESSION['cod_cliente_final']);
        }
        return json_encode($result);
    }

    Public Function UpdateCliente(){
        $dao = new ClienteDao();
        $nroCpf = filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_STRING);
        if (trim($nroCpf)!=''){
            if (BaseModel::validaCPF($nroCpf)){
                $codClienteCPF = $dao->VerificaCPF();
                if ($codClienteCPF[0]){
                    if ($codClienteCPF[1][0]['COD_CLIENTE']>0){
                        $result[0]=false;
                        $result[1]='CPF utilizado em outro cadastro!';
                    }else{
                        $result = $dao->UpdateCliente($_SESSION['cod_cliente_final']);
                    }
                }else{
                    $result = $codClienteCPF;
                }
            }else{
                $result[0]=false;
                $result[1]='CPF inválido!';
            }
        }else{
            $result = $dao->UpdateCliente($_SESSION['cod_cliente_final']);
        }
        return json_encode($result);
    }

    Public Function DeleteCliente(){
        $dao = new ClienteDao();
        $codCliente = filter_input(INPUT_POST, 'codCliente', FILTER_SANITIZE_STRING);
        $vendas = $dao->VendasCliente($codCliente); 
        //var_dump($vendas); die;
        if ($vendas[0]){
            if ($vendas[1]==null){
                $result = $dao->DeleteCliente($codCliente);
            }else{
                $codVendas = '';
                for ($i=0;$i<count($vendas[1]);$i++){                    
                    $codVendas .= $vendas[1][$i]['COD_VENDA'].', ';
                }
                $codVendas = substr($codVendas, 0, strlen($codVendas)-2);
                $result[0]=false;
                $result[1] = 'Cliente cadastrado nestas vendas: '.$codVendas;
            }
        }
        return json_encode($result);
    }

    Public Function ListarVendasPorCliente($json=true){
        $dao = new ClienteDao();
        $lista = $dao->ListarVendasPorCliente($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENDA');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_VENDA_UNITARIA|VLR_VENDA');
        }
        $vlrTotal=0;
        for($i=0;$i<count($lista[1]);$i++){
            $vlrTotal = $vlrTotal+$lista[1][$i]['VLR_VENDA'];
        }
        $lista[3] = number_format($vlrTotal,2,",",".");
        if ($json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
}
?>
