<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/CaixaVendedor/CaixaVendedorDao.php");
class CaixaVendedorModel extends BaseModel
{
    public function CaixaVendedorModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarPagamentosVendedor($Json=true){
        $dao = new CaixaVendedorDao();
        $pagamentosVendedor = $dao->ListarPagamentosVendedor($_SESSION['cod_usuario']);
        if ($pagamentosVendedor[0]){
            $pagamentosVendedor = BaseModel::FormataMoedaInArray($pagamentosVendedor, 'VLR_PAGAMENTO');
            $result[0]=true;
            $result[1]=$pagamentosVendedor[1];
            $pagamentosTipo = $dao->ListarTiposPagamentosVendedor($_SESSION['cod_usuario']);
            if ($pagamentosTipo[0]){
                $pagamentosTipo = BaseModel::FormataMoedaInArray($pagamentosTipo, 'VLR_PAGAMENTO|VLR_TOTAL');
                $result[2] = $pagamentosTipo[1];
            }else{
                $result = $pagamentosTipo;
            }
        }else{
            $result=$pagamentosVendedor;
        }
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }
    }

    Public Function FecharCaixaVendedor($JSON=true){
        $dao = new CaixaVendedorDao();
        $result = $dao->AddFechamentoCaixa($_SESSION['cod_usuario']);
        if ($result[0]){
            $codCaixaVendedor = $result[2];
            $result = $dao->AddPagamentosFechamentoCaixa($codCaixaVendedor, $_SESSION['cod_usuario']);
            if ($result[0]){
                $result = $dao->RetornaUltimoFechamento($codCaixaVendedor);
                $result = BaseModel::AtualizaDataInArray($result, 'DTA_CAIXA', true);
            }
        }
        if ($JSON){
            return json_encode($result);
        }else{
            return $result;        
        }        
    }
    
    Public Function ListarCaixaVendedor($JSON=true){
        $dao = new CaixaVendedorDao();
        $result = $dao->ListarCaixaVendedor($_SESSION['cod_usuario']);
        if($result[0]){
            $result = BaseModel::AtualizaDataInArray($result, 'DTA_CAIXA', true);
            $result = BaseModel::FormataMoedaInArray($result, 'VLR_PAGAMENTO');
        }
        if ($JSON){
            return json_encode($result);
        }else{
            return $result;        
        }   
    }

    Public Function ListarCaixaPorCodigoVendedor($Json=true){
        $dao = new CaixaVendedorDao();
        $pagamentosVendedor = $dao->ListarCaixaPorCodigoVendedor($_SESSION['cod_usuario']);
        if ($pagamentosVendedor[0]){
            $pagamentosVendedor = BaseModel::FormataMoedaInArray($pagamentosVendedor, 'VLR_PAGAMENTO');
            $pagamentosVendedor = BaseModel::AtualizaDataInArray($pagamentosVendedor, 'DTA_CAIXA', true);
            $result[0]=true;
            $result[1]=$pagamentosVendedor[1];
            $pagamentosTipo = $dao->ListarTiposCaixaPorCodigoVendedor($_SESSION['cod_usuario']);
            if ($pagamentosTipo[0]){
                $pagamentosTipo = BaseModel::FormataMoedaInArray($pagamentosTipo, 'VLR_PAGAMENTO|VLR_TOTAL');
                $result[2] = $pagamentosTipo[1];
            }else{
                $result = $pagamentosTipo;
            }
        }else{
            $result=$pagamentosVendedor;
        }
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }
    }
}

