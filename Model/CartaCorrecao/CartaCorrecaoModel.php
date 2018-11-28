<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/CartaCorrecao/CartaCorrecaoDao.php");
include_once("../../Model/EntradaEstoque/EntradaEstoqueModel.php");
include_once("../../Model/VendaReferenciaDevolucao/VendaReferenciaDevolucaoModel.php");
class CartaCorrecaoModel extends BaseModel
{
    Public Function CartaCorrecaoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarSequenciaisGrid(){
        $dao = new CartaCorrecaoDao();
        $lista = $dao->ListarSequenciaisGrid();
        
        return json_encode($lista);
    }

    Public Function DadosEntrada(){
        $dao = new CartaCorrecaoDao();
        $dadosEntrada = $dao->DadosEntrada($_SESSION['cod_cliente_final']);
        $dadosEntrada[1][0]['DTA_ENTRADA'] = $this->ConverteDataBanco($dadosEntrada[1][0]['DTA_ENTRADA']);
        return $dadosEntrada;
    }

    Public Function DadosProdutosEntrada(){
        $dao = new CartaCorrecaoDao();
        return $dao->DadosProdutosEntrada();
    }
    
    Public Function CartaCorrecao(){
        $server = URL;
        $login = TOKEN;
        $password = "";
        $entradaEstoqueModel = new EntradaEstoqueModel();
        $dadosVenda = $entradaEstoqueModel->CarregaDadosEntradaEstoque(false);
        $VendaReferenciaModel = new VendaReferenciaDevolucaoModel();
        $result = $VendaReferenciaModel->RetornaUltimaReferencia(false);
        $ref = "D".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$result[1][0]['NRO_SEQUENCIAL'];        
        if (AMBIENTE=='HMG'){
            $destinatario = "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        }else{
            $destinatario = $dadosVenda[1][0]['DSC_FORNECEDOR'];
        }
        $correcao = array (
          "correcao" => "Frete por conta do Destinatario.",
        );
        // Inicia o processo de envio das informações usando o cURL.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfe/" . $ref  . "/carta_correcao");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($correcao));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // As próximas três linhas são um exemplo de como imprimir as informações de retorno da API.
        print($http_code."\n");
        print($body."\n\n");
        print("");
        curl_close($ch);        
    }
}
?>