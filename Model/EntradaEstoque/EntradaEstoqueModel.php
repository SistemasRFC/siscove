<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/EntradaEstoque/EntradaEstoqueDao.php");
include_once("../../Dao/EntradaEstoque/EntradaEstoqueProdutoDao.php");
include_once("../../Model/VendaReferenciaDevolucao/VendaReferenciaDevolucaoModel.php");
include_once("../../Model/Vendas/VendasModel.php");
class EntradaEstoqueModel extends BaseModel
{
        public static $cnpj_emitente = "31822088000150";
//    public $cnpj_emitente = "26441410000161;
    public static $ie_emitente = "788505100116";
//    public $ie_emitente = "767247800177";
    
    Public Function EntradaEstoqueModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarEntradasEstoqueAberto($Json=true){
        $dao = new EntradaEstoqueDao();
        $lista = $dao->ListarEntradasEstoqueAberto($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_ENTRADA');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_NOTA');
        }
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarEntradasEstoqueFechadas($Json=true){
        $dao = new EntradaEstoqueDao();
        $lista = $dao->ListarEntradasEstoqueFechadas($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_ENTRADA');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_NOTA');
        }
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function CarregaDadosEntradaEstoque($Json=true){
        $dao = new EntradaEstoqueDao();
        $lista = $dao->CarregaDadosEntradaEstoque($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista[1][$i]['DTA_EMISSAO_NOTA'] = substr($lista[1][$i]['DTA_EMISSAO'], 0, 10).'T'.substr($lista[1][$i]['DTA_EMISSAO'], 11, strlen($lista[1][$i]['DTA_EMISSAO'])).'-00:00';
                $lista[1][$i]['DTA_ENTRADA_SAIDA'] = substr($lista[1][$i]['DTA_ENTRADA'], 0, 10).'T'.substr($lista[1][$i]['DTA_ENTRADA'], 11, strlen($lista[1][$i]['DTA_ENTRADA'])).'-00:00';
                $lista[1][$i]['DTA_VENCIMENTO'] = substr($lista[1][$i]['DTA_ENTRADA'], 0, 10);
            }
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_ENTRADA');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_NOTA');
        }        
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function AddEntradaEstoque($Json=true, $nroNotaFiscal=NULL, $dtaEntrada=NULL, $codFornecedor=NULL, $codDeposito=NULL, $txtObs=NULL){
        $dao = new EntradaEstoqueDao();
        $result = $dao->AddEntradaEstoque($_SESSION['cod_usuario'], $_SESSION['cod_cliente_final'], $nroNotaFiscal, $dtaEntrada, $codFornecedor, $codDeposito, $txtObs);
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }
    }

    Public Function UpdateEntradaEstoque($Json=true){
        $dao = new EntradaEstoqueDao();
        $result = $dao->UpdateEntradaEstoque();
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }        
    }
    
    Public Function DeletarEntradaEstoque($JSON=true, $nroSequencialEntrada=NULL){
        $dao = new EntradaEstoqueDao();
        $result = $dao->DeletarEntradaEstoque($nroSequencialEntrada);
        if ($JSON){
            return json_encode($result);
        }else{
            return $result;
        }          
    }
    
    Public Function DevolverNota(){
        $VendaReferenciaDevolucaoModel = new VendaReferenciaDevolucaoModel();
        $result = $VendaReferenciaDevolucaoModel->RetornaVendaReferenciaDevolucao(false);
        if ($result[0]){                
            if ($result[1][0]['NRO_SEQUENCIAL']>0){
                $nroSequencial = $result[1][0]['NRO_SEQUENCIAL'];
                if ($result[1][0]['IND_STATUS_REFERENCIA']=='A'){
                    $result[0]=false;
                    $result[1]="Esta venda já possui uma Nota Devolvida e Autorizada.";
                }else if ($result[1][0]['IND_STATUS_REFERENCIA']=='E'){
                    $result = static::DevolverNotaMercadoria($nroSequencial);
                    if ($result[0]){
                        $result = $VendaReferenciaDevolucaoModel->UpdateVendaReferenciaDevolucao($nroSequencial, 'A');
                    }
                }                
            }else{
                $result = $VendaReferenciaDevolucaoModel->InsertVendaReferenciaDevolucao(false);
                if ($result[0]){
                    $nroSequencial = $result[2];
                    $result = static::DevolverNotaMercadoria($nroSequencial);
                    if (!$result[0]){
                        $VendaReferenciaDevolucaoModel->UpdateVendaReferenciaDevolucao($nroSequencial, 'E');
                    }
                }
            }
        }
        return json_encode($result);
    }
    
    Public Function DevolverNotaMercadoria($nroSequencial){
        $NfeDao = new EntradaEstoqueDao();
        $server = URL;
        $login = TOKEN;
        $password = "";
        $dadosVenda = $this->CarregaDadosEntradaEstoque(false);
//        var_dump(static::RetornaProdutosNfe()); die;
        if (AMBIENTE=='HMG'){
            $destinatario = "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        }else{
            $destinatario = $dadosVenda[1][0]['DSC_CLIENTE'];
        }
        $ref = "D".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$nroSequencial;
        $vlrOriginal = str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_NOTA']))+0.01;
        
        $nfe = array (
            "natureza_operacao" => "Devolução",
            "forma_pagamento" => "0",
            "data_emissao" => $dadosVenda[1][0]['DTA_EMISSAO_NOTA'],
            "data_entrada_saida" => $dadosVenda[1][0]['DTA_EMISSAO_NOTA'],
            "tipo_documento" => "0",
            "finalidade_emissao" => "4",
            "cnpj_emitente" => self::$cnpj_emitente,
            "inscricao_estadual_emitente" => self::$ie_emitente,
            "local_destino" => "1",
            "nome_destinatario" => $destinatario,
            "cnpj_destinatario" => $dadosVenda[1][0]['NRO_CNPJ'],
            "inscricao_estadual_destinatario" => $dadosVenda[1][0]['NRO_IE'],
            "logradouro_destinatario" => $dadosVenda[1][0]['TXT_LOGRADOURO'],
            "numero_destinatario" => $dadosVenda[1][0]['TXT_COMPLEMENTO'],
            "bairro_destinatario" => $dadosVenda[1][0]['NME_BAIRRO'],
            "municipio_destinatario" => $dadosVenda[1][0]['TXT_LOCALIDADE'],
            "uf_destinatario" => $dadosVenda[1][0]['SGL_UF'],
            "pais_destinatario" => "Brasil",
            "cep_destinatario" => $dadosVenda[1][0]['NRO_CEP'],
            "icms_base_calculo" => "0",
            "icms_valor_total" => "0",
            "icms_base_calculo_st" => "0",
            "icms_valor_total_st" => "0",
            "icms_modalidade_base_calculo" => "0",
            "icms_valor" => "0",
            "valor_frete" => "0.0000",
            "valor_seguro" => "0",
            "valor_total" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_NOTA'])),
            "valor_produtos" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_NOTA'])),
            "valor_ipi" => "0",
            "modalidade_frete" => "0",
            "informacoes_adicionais_contribuinte" => "Não Incidência ICMS conforme Decisão...",
            "items" => static::RetornaProdutosNfe(),
            "valor_original_fatura" => $vlrOriginal,
            "valor_desconto_fatura" => "0.01",
            "valor_liquido_fatura" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_NOTA'])), 
            "numero_fatura" => 1,
            "notas_referenciadas" => array(
                array(
                    "chave_nfe" => $dadosVenda[1][0]['NRO_NOTA_FISCAL']
                )
            )
        );        
//        var_dump($nfe); die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $server."/v2/nfe?ref=" . $ref);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nfe));        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        var_dump($body); die;
        curl_close($ch); 
        if ($http_code!=202){
            switch ($http_code){
                case 422:
                    $result[0]=false;
                    $result[1]="Chave inválida!";
                    $NfeDao->RegistraErrosDevolucao($ref, $result[1]);
                    break;                  
                default:
                    $result[0] = false;
                    $result[1] = "Foram encontrados ".count($body->erros)." erros, listados abaixo!";
                    for ($i=0;$i<count($body->erros);$i++){
                        $result[2][]=$i+1 . " - ".$body->erros[$i]->mensagem."<BR>";
                        $NfeDao->RegistraErrosDevolucao($ref, $body->erros[$i]->mensagem);
                    }
                    break;
            }
        }else{
            $produtosDao = new EntradaEstoqueProdutoDao();
            $listaProdutos = $produtosDao->ListarDadosProdutosEntrada($nroSequencial);
            if ($listaProdutos[0]){
                for ($i=0;$i<count($listaProdutos[1]);$i++){
                    $produtosDao->AtualizaEstoque('REMOVE', 
                                                  $listaProdutos[1][$i]['QTD_ENTRADA'], 
                                                  $listaProdutos[1][$i]['COD_PRODUTO'], 
                                                  $listaProdutos[1][$i]['NRO_SEQUENCIAL']);  
                }
            }
            $result[0]=true;
        }
        return $result;
    }
    
    Public Static Function RetornaProdutosNfe(){
        $NfeDao = new EntradaEstoqueDao();
        $produtosVendas = $NfeDao->RetornaMercadoriasVenda();
        for ($i=0;$i<count($produtosVendas[1]);$i++){
            $item = $i+1;
            if ($produtosVendas[1][$i]['TPO_PRODUTO']=='S'){
                $tpoUnidade = "SV";
            }else{
                $tpoUnidade = "UN";
            }
            $vlrSoma = ($produtosVendas[1][$i]['VLR_VENDA'])*$produtosVendas[1][$i]['QTD_ENTRADA'];
            $produtos[$i] = array("numero_item" => $item.'',
                                "codigo_produto" => $produtosVendas[1][$i]['COD_PRODUTO'],
                                "descricao" => $produtosVendas[1][$i]['DSC_PRODUTO'],
                                "cfop" => "1202",//$produtosVendas[1][$i]['COD_CFOP'],
                                "unidade_comercial" => $tpoUnidade,
                                "quantidade_comercial" => $produtosVendas[1][$i]['QTD_ENTRADA'],
                                "valor_unitario_comercial" => number_format($produtosVendas[1][$i]['VLR_VENDA'],2,'.',''),
                                "valor_unitario_tributavel" => number_format($produtosVendas[1][$i]['VLR_VENDA'],2,'.',''),
                                "unidade_tributavel" => "un",
                                "codigo_ncm" => $produtosVendas[1][$i]['COD_NCM'],
                                "quantidade_tributavel" => $produtosVendas[1][$i]['QTD_ENTRADA'],
                                "valor_bruto" => number_format($vlrSoma,2,'.',''),
                                "icms_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_ICMS'],
                                "icms_origem" => $produtosVendas[1][$i]['COD_ICMS_ORIGEM'],
                                "pis_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_PIS'],
                                "cofins_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_COFINS']);                
                                
        } 
//        var_dump($produtos); die;
        return $produtos;
    }
    
    Public Function ConsultarNota($json=true){
        $server = URL;
        $login = TOKEN;
        $password = "";        
        $VendaReferenciaModel = new VendaReferenciaDevolucaoModel();
        $result = $VendaReferenciaModel->RetornaUltimaReferencia(false);
        if ($result[0]){
            switch ($result[1][0]['IND_STATUS_REFERENCIA']) {
                case 'A':
                    $ref = "D".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$result[1][0]['NRO_SEQUENCIAL'];
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $server."/v2/nfe/" . $ref);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array());
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

                    $body = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $body = json_decode($body);
                    if ($body!=''){
            //            var_dump($body); die;
                        if (isset($body->codigo)){
                            $retorno[0]=false;
                            $retorno[1]=$body->mensagem;
                            $retorno[2]=true;
                        }else if (isset($body->status)){
                            switch ($body->status) {
                                case "erro_autorizacao":
                                    if (property_exists($body, 'mensagem_sefaz')){
                                        $VendaReferenciaModel = new VendaReferenciaDevolucaoModel();
                                        $VendaModel = new VendasModel();
                                        $NfeDao = new NfeDao();
                                        $result = $VendaReferenciaModel->RetornaVendaReferenciaDevolucao(false);
                                        if ($result[0]){                    
                                            $nroSequencial = $result[1][0]['NRO_SEQUENCIAL'];
                                            $result = $VendaReferenciaModel->UpdateVendaReferenciaDevolucao($nroSequencial, 'E');
                                            $VendaModel->ReabrirVenda();
                                        }                
                                        $retorno[0]=false;
                                        $retorno[1]=$body->mensagem_sefaz;
                                        $retorno[2]=true;
                                        $NfeDao->RegistraErros($ref, $body->mensagem_sefaz);
                                    }
                                    break;
                                default:
                                    if(isset($body->caminho_danfe)){
                                        $retorno[0]=true;
                                        $retorno[1]['nmeCaminhoDanfe'] = "https://api.focusnfe.com.br/".$body->caminho_danfe;        
                                        $retorno[1]['chaveNfe'] = $body->chave_nfe;        
                                        $retorno[2] = true;
                                    }else{
                                        $retorno[0]=false;
                                        $retorno[1] = 'Ainda não foi disponibilizado o arquivo PDF da Nota!<br>Tente em alguns instantes!';
                                        $retorno[2] = false;
                                    }                        
                                    break;
                            }

                        }
                    }else{
                        $retorno=null;
                    }
                    break;
                case 'E':
                    $retorno[0] = false;
                    $retorno[1] = 'Erro ao enviar a última nota!';
                    $retorno[2] = false;
                    break;            
                default:
                    break;
            }
        }
        
        $result = $retorno;
        if ($json){
            return json_encode($result);
        }
        return $result;
    }
    
    Public Function DevolverNotaGarantia(){
        $VendaReferenciaDevolucaoModel = new VendaReferenciaDevolucaoModel();
        $result = $VendaReferenciaDevolucaoModel->RetornaVendaReferenciaDevolucao(false);
        if ($result[0]){                
            if ($result[1][0]['NRO_SEQUENCIAL']>0){
                $nroSequencial = $result[1][0]['NRO_SEQUENCIAL'];
                if ($result[1][0]['IND_STATUS_REFERENCIA']=='A'){
                    $result[0]=false;
                    $result[1]="Esta venda já possui uma Nota Devolvida e Autorizada.";
                }else if ($result[1][0]['IND_STATUS_REFERENCIA']=='E'){
                    $result = static::DevolverNotaGarantiaMercadoria($nroSequencial);
                    if ($result[0]){
                        $result = $VendaReferenciaDevolucaoModel->UpdateVendaReferenciaDevolucao($nroSequencial, 'A');
                    }
                }                
            }else{
                $result = $VendaReferenciaDevolucaoModel->InsertVendaReferenciaDevolucao(false);
                if ($result[0]){
                    $nroSequencial = $result[2];
                    $result = static::DevolverNotaGarantiaMercadoria($nroSequencial);
                    if (!$result[0]){
                        $VendaReferenciaDevolucaoModel->UpdateVendaReferenciaDevolucao($nroSequencial, 'E');
                    }
                }
            }
        }
        return json_encode($result);
    }
    
    Public Function DevolverNotaGarantiaMercadoria($nroSequencial){
        $NfeDao = new EntradaEstoqueDao();
        $server = URL;
        $login = TOKEN;
        $password = "";
        $dadosVenda = $this->CarregaDadosEntradaEstoque(false);
        if (AMBIENTE=='HMG'){
            $destinatario = "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        }else{
            $destinatario = $dadosVenda[1][0]['DSC_FORNECEDOR'];
        }
        $ref = "D".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$nroSequencial;
        $vlrTotal = static::RetornaValorTotal();
        $vlrOriginal = $vlrTotal+0.01;
        
        $nfe = array (
            "natureza_operacao" => "Devolução",
            "forma_pagamento" => "0",
            "data_emissao" => $dadosVenda[1][0]['DTA_EMISSAO_NOTA'],
            "data_entrada_saida" => $dadosVenda[1][0]['DTA_EMISSAO_NOTA'],
            "tipo_documento" => "1",
            "finalidade_emissao" => "1",
            "cnpj_emitente" => self::$cnpj_emitente,
            "inscricao_estadual_emitente" => self::$ie_emitente,
            "local_destino" => $dadosVenda[1][0]['SGL_UF']=='DF'?"1":"2",
            "nome_destinatario" => $destinatario,
            "cnpj_destinatario" => $dadosVenda[1][0]['NRO_CNPJ'],
            "inscricao_estadual_destinatario" => $dadosVenda[1][0]['NRO_IE'],
            "logradouro_destinatario" => $dadosVenda[1][0]['TXT_LOGRADOURO'],
            "numero_destinatario" => $dadosVenda[1][0]['TXT_COMPLEMENTO'],
            "bairro_destinatario" => $dadosVenda[1][0]['NME_BAIRRO'],
            "municipio_destinatario" => $dadosVenda[1][0]['TXT_LOCALIDADE'],
            "uf_destinatario" => $dadosVenda[1][0]['SGL_UF'],
            "pais_destinatario" => "Brasil",
            "cep_destinatario" => $dadosVenda[1][0]['NRO_CEP'],
            "icms_base_calculo" => "0",
            "icms_valor_total" => "0",
            "icms_base_calculo_st" => "0",
            "icms_valor_total_st" => "0",
            "icms_modalidade_base_calculo" => "0",
            "icms_valor" => "0",
            "valor_frete" => "0.0000",
            "valor_seguro" => "0",
            "valor_total" => str_replace(',', '.', str_replace('.', '', $vlrTotal)),
            "valor_produtos" => str_replace(',', '.', str_replace('.', '', $vlrTotal)),
            "valor_ipi" => "0",
            "modalidade_frete" => "0",
            "informacoes_adicionais_contribuinte" => "Não Incidência ICMS conforme Decisão...",
            "items" => static::RetornaProdutosGarantiaNfe($dadosVenda[1][0]['SGL_UF']),
            "valor_original_fatura" => $vlrOriginal,
            "valor_desconto_fatura" => "0.01",
            "valor_liquido_fatura" => str_replace(',', '.', str_replace('.', '', $vlrTotal)), 
            "numero_fatura" => 1,
            "notas_referenciadas" => array(
                array(
                    "chave_nfe" => $dadosVenda[1][0]['NRO_NOTA_FISCAL']
                )
            )
        );        
//        var_dump($nfe); die;
//        echo json_encode($nfe); die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $server."/v2/nfe?ref=" . $ref);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nfe));        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 
        if ($http_code!=202){
            switch ($http_code){
                case 422:
                    $result[0]=false;
                    $result[1]="Chave inválida!";
                    $NfeDao->RegistraErrosDevolucao($ref, $result[1]);
                    break;  
                case 500:
                    $result[0]=false;
                    $result[1]="Erro no Servidor!";
                    $NfeDao->RegistraErrosDevolucao($ref, $result[1]);
                    break; 
                default:
                    $result[0] = false;
                    $result[1] = "Foram encontrados ".count($body->erros)." erros, listados abaixo!";
                    for ($i=0;$i<count($body->erros);$i++){
                        $result[2][]=$i+1 . " - ".$body->erros[$i]->mensagem."<BR>";
                        $NfeDao->RegistraErrosDevolucao($ref, $body->erros[$i]->mensagem);
                    }
                    break;
            }
        }else{
            $produtosDao = new EntradaEstoqueProdutoDao();
            $listaProdutos = $produtosDao->ListarDadosProdutosEntrada($nroSequencial);
            if ($listaProdutos[0]){
                for ($i=0;$i<count($listaProdutos[1]);$i++){
                    $produtosDao->AtualizaEstoque('REMOVE', 
                                                  $listaProdutos[1][$i]['QTD_ENTRADA'], 
                                                  $listaProdutos[1][$i]['COD_PRODUTO'], 
                                                  $listaProdutos[1][$i]['NRO_SEQUENCIAL']);  
                }
            }
            $result[0]=true;
        }
        return $result;
    }
    
    Public Static Function RetornaProdutosGarantiaNfe($sglUf){
        $NfeDao = new EntradaEstoqueDao();
        $produtosVendas = $NfeDao->RetornaMercadoriasVenda();
        $codProdutos = $NfeDao->Populate('codProdutos');
        $arrProdutos = explode(';', $codProdutos);
        $item = 0;
        for ($i=0;$i<count($produtosVendas[1]);$i++){
            for ($j=0;$j<count($arrProdutos);$j++){
                $registro = explode('|', $arrProdutos[$j]);
                if ($registro[0]==$produtosVendas[1][$i]['COD_PRODUTO'] && (int) $registro[1]>0){
                    $item = $item+1;
                    if ($produtosVendas[1][$i]['TPO_PRODUTO']=='S'){
                        $tpoUnidade = "SV";
                    }else{
                        $tpoUnidade = "UN";
                    }
                    $vlrSoma = ($produtosVendas[1][$i]['VLR_VENDA'])*$registro[1];
                    $produtos[$item-1] = array("numero_item" => $item.'',
                                        "codigo_produto" => $produtosVendas[1][$i]['COD_PRODUTO'],
                                        "descricao" => $produtosVendas[1][$i]['DSC_PRODUTO'],
                                        "cfop" => $sglUf=='DF'?"5949":"6949",//$produtosVendas[1][$i]['COD_CFOP'],
                                        "unidade_comercial" => $tpoUnidade,
                                        "quantidade_comercial" => $registro[1],
                                        "valor_unitario_comercial" => number_format($produtosVendas[1][$i]['VLR_VENDA'],2,'.',''),
                                        "valor_unitario_tributavel" => number_format($produtosVendas[1][$i]['VLR_VENDA'],2,'.',''),
                                        "unidade_tributavel" => "un",
                                        "codigo_ncm" => $produtosVendas[1][$i]['COD_NCM'],
                                        "quantidade_tributavel" => $registro[1],
                                        "valor_bruto" => number_format($vlrSoma,2,'.',''),
                                        "icms_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_ICMS'],
                                        "icms_origem" => $produtosVendas[1][$i]['COD_ICMS_ORIGEM'],
                                        "pis_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_PIS'],
                                        "cofins_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_COFINS']);                
                }
            }
        } 
//        var_dump($produtos); die;
        return $produtos;
    }
    
    Public Function RetornaValorTotal(){
        $NfeDao = new EntradaEstoqueDao();
        $produtosVendas = $NfeDao->RetornaMercadoriasVenda();
        $codProdutos = $NfeDao->Populate('codProdutos');
        $arrProdutos = explode(';', $codProdutos);
        for ($i=0;$i<count($produtosVendas[1]);$i++){
            for ($j=0;$j<count($arrProdutos);$j++){
                $registro = explode('|', $arrProdutos[$j]);
                if ($registro[0]==$produtosVendas[1][$i]['COD_PRODUTO'] && (int) $registro[1]>0){
                    $vlrSoma = ($produtosVendas[1][$i]['VLR_VENDA'])*$registro[1];               
                }
            }
        } 
        return str_replace(',', '.', str_replace('.', '', $vlrSoma));
    }
    
    Public Function CartaCorrecao(){
        $server = URL;
        $login = TOKEN;
        $password = "";
        $dadosVenda = $this->CarregaDadosEntradaEstoque(false);
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
//        print($http_code."\n");
//        print($body."\n\n");
//        print("");
        $body = json_decode($body);
        $result[0]=true;
        $result[1]=URL.$body->caminho_pdf_carta_correcao; 
        curl_close($ch);        
        echo json_encode($result);
    }
}