<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/CaixaGerencia/CaixaGerenciaDao.php");
class CaixaGerenciaModel extends BaseModel
{
    public function CaixaGerenciaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarCaixasFechadosGerencia($Json=true){
        $dao = new CaixaGerenciaDao();
        $caixasFechados = $dao->ListarCaixasFechadosGerencia($_SESSION['cod_usuario']);
        if ($caixasFechados[0]){
            $caixasFechados = BaseModel::FormataMoedaInArray($caixasFechados, 'VLR_CAIXA_VENDEDOR');
            $caixasFechados = BaseModel::AtualizaDataInArray($caixasFechados, 'DTA_CAIXA_GERENCIA', true);
        }
        if ($Json){
            return json_encode($caixasFechados);
        }else{
            return $result;        
        }
    }

    Public Function ListarCaixasVendedor($Json=true){
        $dao = new CaixaGerenciaDao();
        $caixasFechados = $dao->ListarCaixasVendedor();
        if ($caixasFechados[0]){
            $caixasFechados = BaseModel::FormataMoedaInArray($caixasFechados, 'VLR_PAGAMENTO');
            $caixasFechados = BaseModel::AtualizaDataInArray($caixasFechados, 'DTA_CAIXA', true);
            $result[0]=true;
            $result[1]=$caixasFechados[1];
            $resumo = $dao->ListarResumoCaixasVendedor();
            if ($resumo[0]){
                $resumo = BaseModel::FormataMoedaInArray($resumo, 'VLR_PAGAMENTO|VLR_TOTAL');
                $result[2] = $resumo[1];
            }
        }
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }
    }

    Public Function FecharCaixaGerencia($JSON=true){
        $dao = new CaixaGerenciaDao();
        $result = $dao->AddFechamentoCaixa($_SESSION['cod_usuario']);
        if ($result[0]){
            $codCaixaGerencia = $result[2];
            $result = $dao->AddPagamentosFechamentoCaixa($codCaixaGerencia, $_SESSION['cod_usuario']);
            if ($result[0]){
                $result = $dao->RetornaUltimoFechamento($codCaixaGerencia);
                $result = BaseModel::AtualizaDataInArray($result, 'DTA_CAIXA_GERENCIA', true);
            }
        }
        if ($JSON){
            return json_encode($result);
        }else{
            return $result;        
        }        
    }

    Public Function ListarCaixasVendedorPorCodigo($Json=true){
        $dao = new CaixaGerenciaDao();
        $caixasFechados = $dao->ListarCaixasVendedorPorCodigo();
        if ($caixasFechados[0]){
            $caixasFechados = BaseModel::FormataMoedaInArray($caixasFechados, 'VLR_PAGAMENTO');
            $caixasFechados = BaseModel::AtualizaDataInArray($caixasFechados, 'DTA_CAIXA', true);
            $result[0]=true;
            $result[1]=$caixasFechados[1];
            $resumo = $dao->ListarResumoCaixasVendedorPorCodigo();
            if ($resumo[0]){
                $resumo = BaseModel::FormataMoedaInArray($resumo, 'VLR_PAGAMENTO|VLR_TOTAL');
                $result[2] = $resumo[1];
            }
        }
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }
    }
    
}

