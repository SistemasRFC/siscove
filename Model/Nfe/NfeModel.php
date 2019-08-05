<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Nfe/NfeDao.php");
include_once("../../Model/Vendas/VendasModel.php");
include_once("../../Model/Vendas/ProdutosVendasModel.php");
include_once("../../Model/VendaReferencia/VendaReferenciaModel.php");
class NfeModel extends BaseModel
{
    public static $cnpj_emitente = "31822088000150";
//    public $cnpj_emitente = "26441410000161;
    public static $ie_emitente = "788505100116";
//    public $ie_emitente = "767247800177";
    
    public function NfeModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }
    
    


    Public Function AutorizarNota(){
        $VendaReferenciaModel = new VendaReferenciaModel();
        $result = $VendaReferenciaModel->RetornaUltimaReferencia(false);
        if ($result[0]){                
            if ($result[1][0]['NRO_SEQUENCIAL']>0){
                $nroSequencial = $result[1][0]['NRO_SEQUENCIAL'];
                if ($result[1][0]['IND_STATUS_REFERENCIA']=='A'){
                    $result[0]=false;
                    $result[1]="Esta venda já possui uma Nota Emitida e Autorizada.";
                }else if ($result[1][0]['IND_STATUS_REFERENCIA']=='E'){
                    $result = static::EmitirNotaMercadoria($nroSequencial);
                    if ($result[0]){
                        $result = $VendaReferenciaModel->UpdateVendaReferencia($nroSequencial, 'A');
                    }
                }
            }else{
                $result = $VendaReferenciaModel->InsertVendaReferencia(false);
                if ($result[0]){
                    $nroSequencial = $result[2];
                    $result = static::EmitirNotaMercadoria($nroSequencial);
                    if (!$result[0]){
                        $VendaReferenciaModel->UpdateVendaReferencia($nroSequencial, 'E');
                    }
                }
            }
        }
//        if ($result[0]){
//            $result[2] = false;
//            while (!$result[2]){
//                $result = $this->ConsultarNota(false);
//            }
//        }
        return json_encode($result);
    }
    
    Public Static Function EmitirNotaMercadoria($referencia){
        $server = URL;
        $login = TOKEN;
        $password = "";
        $ref = filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$referencia;
        $NfeDao = new NfeDao();
        $VendaModel = new VendasModel();
        $dadosVenda = $VendaModel->CarregaDadosVenda(FALSE);
        if (AMBIENTE=='HMG'){
            $destinatario = "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        }else{
            $destinatario = $dadosVenda[1][0]['DSC_CLIENTE'];
        }
        $vlrOriginal = str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA']))+0.01;
//        $vlrLiquido = str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA']))-0.01;
        if ($dadosVenda[1][0]['IND_TIPO_CLIENTE']=='J'){
            $nfe = array (
                "natureza_operacao" => "Remessa de Produtos",
                "forma_pagamento" => "0",
                "data_emissao" => $dadosVenda[1][0]['DTA_EMISSAO_NOTA'],
                "tipo_documento" => "1",
                "finalidade_emissao" => "1",
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
                "valor_total" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA'])),
                "valor_produtos" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_VENDA'])),
                "valor_ipi" => "0",
                "modalidade_frete" => "0",
                "informacoes_adicionais_contribuinte" => "Não Incidência ICMS conforme Decisão...",
                "items" => static::RetornaProdutosNfe(),
                "valor_original_fatura" => $vlrOriginal,
                "valor_desconto_fatura" => "0.01",
                "valor_liquido_fatura" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA'])), 
                "numero_fatura" => 1,
                "duplicatas" => array(
                    array(
                        "data_vencimento" => $dadosVenda[1][0]['DTA_VENCIMENTO'],
                        "numero" => "001",
                        "valor" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA']))
                    )
                ),
            );            
        }else{
            $nfe = array (
                "natureza_operacao" => "Remessa de Produtos",
                "forma_pagamento" => "0",
                "data_emissao" => $dadosVenda[1][0]['DTA_EMISSAO_NOTA'],
                "tipo_documento" => "1",
                "finalidade_emissao" => "1",
                "cnpj_emitente" => self::$cnpj_emitente,
                "inscricao_estadual_emitente" => self::$ie_emitente,
                "local_destino" => "1",
                "nome_destinatario" => $destinatario,
                "cpf_destinatario" => $dadosVenda[1][0]['NRO_CPF'],
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
                "valor_total" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA'])),
                "valor_produtos" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_VENDA'])),
                "valor_ipi" => "0",
                "modalidade_frete" => "0",
                "informacoes_adicionais_contribuinte" => "Não Incidência ICMS conforme Decisão...",
                "items" => static::RetornaProdutosNfe(),
                "valor_original_fatura" => $vlrOriginal,
                "valor_desconto_fatura" => "0.01",
                "valor_liquido_fatura" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA'])),
                "numero_fatura" => 1,
                "duplicatas" => array(
                    array(
                        "data_vencimento" => $dadosVenda[1][0]['DTA_VENCIMENTO'],
                        "numero" => "001",
                        "valor" => str_replace(',', '.', str_replace('.', '', $dadosVenda[1][0]['VLR_TOTAL_VENDA']))
                    )
                ),
            );
        }
//        var_dump($nfe); die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $server."/v2/nfe?ref=" . $ref);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nfe));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $body = json_decode($body);
        curl_close($ch); 
        if ($http_code!=202){
            switch ($http_code){
                case 422:
                    $result[0] = false;
                    $result[1] = "A Nota Fiscal já foi autorizada!";
                    $NfeDao->RegistraErros($ref, $result[1]);
                default:
                    $result[0] = false;
                    $result[1] = $body->mensagem;
            }
        }else{
            $result[0] = true;
        }
        return $result;
    }
    
    Public Static Function RetornaProdutosNfe(){
        $NfeDao = new NfeDao();
        $produtosVendas = $NfeDao->RetornaMercadoriasVenda();
        for ($i=0;$i<count($produtosVendas[1]);$i++){
            $item = $i+1;
            if ($produtosVendas[1][$i]['TPO_PRODUTO']=='S'){
                $tpoUnidade = "SV";
            }else{
                $tpoUnidade = "UN";
            }
            $vlrSoma = ($produtosVendas[1][$i]['VLR_VENDA']-$produtosVendas[1][$i]['VLR_DESCONTO'])*$produtosVendas[1][$i]['QTD_VENDIDA'];
            $vlrVenda = ($produtosVendas[1][$i]['VLR_VENDA']-$produtosVendas[1][$i]['VLR_DESCONTO']);
            $produtos[$i] = array("numero_item" => $item.'',
                                "codigo_produto" => $produtosVendas[1][$i]['COD_PRODUTO'],
                                "descricao" => $produtosVendas[1][$i]['DSC_PRODUTO'],
                                "cfop" => $produtosVendas[1][$i]['COD_CFOP'],
                                "unidade_comercial" => $tpoUnidade,
                                "quantidade_comercial" => $produtosVendas[1][$i]['QTD_VENDIDA'],
                                "valor_unitario_comercial" => number_format($vlrVenda,2,'.',''),
                                "valor_unitario_tributavel" => number_format($vlrVenda,2,'.',''),
                                "unidade_tributavel" => "un",
                                "codigo_ncm" => $produtosVendas[1][$i]['COD_NCM'],
                                "quantidade_tributavel" => $produtosVendas[1][$i]['QTD_VENDIDA'],
                                "valor_bruto" => number_format($vlrSoma,2,'.',''),
                                "icms_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_ICMS'],
                                "icms_origem" => $produtosVendas[1][$i]['COD_ICMS_ORIGEM'],
                                "pis_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_PIS'],
                                "cofins_situacao_tributaria" => $produtosVendas[1][$i]['DSC_CODIGO_COFINS']);                
                                
        }
        return $produtos;
    }
    
    Public Function VerificaNota(){
        $VendaReferenciaModel = new VendaReferenciaModel();
        $result = $VendaReferenciaModel->RetornaVendaReferencia(false);
        if ($result[0]){                
            if ($result[1][0]['NRO_SEQUENCIAL']>0){
                if ($result[1][0]['IND_STATUS_REFERENCIA']=='A'){
                    $dataEmissao = $result[1][0]['DTA_EMISSAO_NOTA'];
                    $codVenda = $result[1][0]['COD_VENDA'];
                    $difHoras = BaseModel::diffDate($dataEmissao, date('Y-m-d H:i:s'));
                    if ($difHoras>24){
                        $result[0]=false;
                        $result[1]="Prazo para cancelamento expirou!";
                    }else{
                        $result[0]=false;
                        $result[1]='Venda com Nota Fiscal de Produtos Emitida para a Receita e aprovada!<br>
                                    Deseja Cancelar a nota anterior?<br>
                                    <input type="button" value="Sim" onclick="javascript:CancelarNota('.$codVenda.');">
                                    <input type="button" value="Não" onclick="javascript:FecharDialog();">';
                    }
                }else{
                    $result[0]=true;
                }
            }else{
                $result[0]=true;
            }
        }        
        return $result;
    }
    
    Public Function ConsultarNota($json=true){
        $server = URL;
        $login = TOKEN;
        $password = "";        
        $VendaReferenciaModel = new VendaReferenciaModel();
        $result = $VendaReferenciaModel->RetornaUltimaReferencia(false);
        if ($result[0]){
            switch ($result[1][0]['IND_STATUS_REFERENCIA']) {
                case 'A':
                    $ref = filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$result[1][0]['NRO_SEQUENCIAL'];
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
                                        $VendaReferenciaModel = new VendaReferenciaModel();
                                        $VendaModel = new VendasModel();
                                        $NfeDao = new NfeDao();
                                        $result = $VendaReferenciaModel->RetornaVendaReferencia(false);
                                        if ($result[0]){                    
                                            $nroSequencial = $result[1][0]['NRO_SEQUENCIAL'];
                                            $result = $VendaReferenciaModel->UpdateVendaReferencia($nroSequencial, 'E');
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
    
    Public Function CancelarNota(){
        $VendaReferenciaModel = new VendaReferenciaModel();
        $result = $VendaReferenciaModel->RetornaUltimaReferencia(false);
        if ($result[0]){
            $nroSequencial = $result[1][0]['NRO_SEQUENCIAL'];
            if ($nroSequencial>0){
                $server = URL;
                $login = TOKEN;
                $password = "";        
                $ref = filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."00".$nroSequencial;
                $justificativa = array ("justificativa" => "Teste de cancelamento de nota");
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfe/" . $ref);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($justificativa));
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

                $body = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($http_code==200){
                    $result[0] = true; 
                }else{
                    $result[0] = false;
                    $result[1] = "A nota fiscal já foi cancelada!";
                }
                curl_close($ch);
                if ($result[0]){
                    $VendaReferenciaModel->UpdateVendaReferencia($nroSequencial, 'C');
                }
            }
        }
        return json_encode($result);
    }
    
    Public Function EnviarEmail(){
        $NfeDao = new NfeDao();
        $emailCliente = $NfeDao->VerificaEmailCliente();
        if ($emailCliente[0] && $emailCliente[1]!=NULL){
            if ($emailCliente[1][0]['NRO_STATUS_VENDA']=='F'){
                $emailCli = $emailCliente[1][0]['TXT_EMAIL'];
                $nomeCli = $emailCliente[1][0]['DSC_CLIENTE'];
                $nfe = $this->ConsultarNota();
                if($nfe[0] && $nfe[1]!=NULL){
                    $nfeVenda = $nfe[1]['nmeCaminhoDanfe'];
                    /*
                    * pegar o email do cliente pelo codigo da venda
                    * consultar nfe
                    */
                    require_once('../../Resources/PHPMailer_5.2.4/class.phpmailer.php');
                    include("../../Resources/PHPMailer_5.2.4/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

                    $mail             = new PHPMailer();

                    $mail->IsSMTP(); // telling the class to use SMTP
                    $mail->Host       = "smtp.gmail.com"; // SMTP server
                    $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                                               // 1 = errors and messages
                                                               // 2 = messages only
                    $mail->SMTPAuth   = true;                  // enable SMTP authentication
                    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
                    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
                    $mail->Username   = "sistemasiscove";  // GMAIL username
                    $mail->Password   = "Rfm1440@";            // GMAIL password
                    $mail->SetFrom("sistemasiscove@gmail.com", "No-Reply");
                    $mail->Subject    = utf8_decode("Nota Fiscal Eletrônica");

                    $arqDestino = '/var/www/html/siscovehmg/Resources/notas/nota'.$NfeDao->Populate('codVenda').'.pdf';

                    copy($nfeVenda, $arqDestino);

                    $mail->MsgHTML("Esta &eacute; uma mensagem autom&aacute;tica, favor n&atilde;o responder!
                                    <br>
                                    <br>
                                    Prezado(a) ".$nomeCli.", 
                                    <br>
                                    Segue, em anexo, o arquivo da nota fiscal referente a venda ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT).".");
                    $mail->AddAttachment($arqDestino);   
                    $mail->AddAddress($emailCli, $nomeCli);

                    $envio = $mail->Send();
                    if(!$envio) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                        $result[0] = false;
                        $result[1] = "Erro ao enviar o email!";
                    } else {
                        $result[0] = true;
                        $result[1] = "Email enviado!";
                    }
                    unlink($arqDestino);
                }else{
                    $result[0] = false;
                    $result[1] = "Essa venda não possui nota gerada!";
                }
            }else{
                $result[0]=false;
                $result[1] = "Esta venda não está fechada!";
            }
        }
        echo json_encode($result);
    }
}