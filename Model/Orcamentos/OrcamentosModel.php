<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Orcamentos/OrcamentosDao.php");
class OrcamentosModel extends BaseModel
{
    function OrcamentosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    function ListarOrcamentosAberto($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->ListarOrcamentosAberto($_SESSION['cod_cliente_final']);
        for($i=0;$i<count($lista[1]);$i++){
            $lista[1][$i]['DTA_VENDA'] = BaseModel::ConverteDataBanco($lista[1][$i]['DTA_VENDA']);
            
        }        
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_VENDA');
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    function ListarOrcamentosCliente($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->ListarOrcamentosCliente();
        for($i=0;$i<count($lista[1]);$i++){
            $lista[1][$i]['DTA_VENDA'] = BaseModel::ConverteDataBanco($lista[1][$i]['DTA_VENDA']);
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
    }

    function VerificaOrcamentosAberto($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->VerificaOrcamentosAberto($_SESSION['cod_usuario']);
        if ($lista[1][0]['QTD']>0){
            $retorno = true;
        }else{
            $retorno = false;
        }
        if($Json){
            return json_encode($retorno);
        }else{
            return $retorno;
        }
    }

    function ListarOrcamentos($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->ListarOrcamentos($_SESSION['cod_cliente_final']);
        for($i=0;$i<count($lista[1]);$i++){
            $lista[1][$i]['DTA_VENDA'] = BaseModel::ConverteDataBanco($lista[1][$i]['DTA_VENDA']);
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        } 
    }

    function CarregaDadosVenda($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->CarregaDadosVenda();
        for($i=0;$i<count($lista[1]);$i++){
            $lista[1][$i]['DTA_VENDA'] = BaseModel::ConverteDataBanco($lista[1][$i]['DTA_VENDA']);
            $lista[1][$i]['VLR_SOMA_LABEL'] = $lista[1][$i]['VLR_VENDA'];
        }
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_VENDA|VLR_DESCONTO');
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    function InsertVenda($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->InsertVenda($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
    }

    function UpdateVenda($Json=true){
        $dao = new OrcamentosDao();
        $lista = $dao->UpdateVenda();
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }  
    }

    function CancelarVenda(){
        $dao = new OrcamentosDao();
        $PVdao = new ProdutosOrcamentosDao();
        $lista = $PVdao->ListarProdutosVenda();
        for ($i=0;$i<count($lista);$i++){
            if ($lista[$i]['IND_ESTOQUE']=="S"){
                $PVdao->AtualizaEstoque("ADD",
                                      $lista[$i]['COD_PRODUTO'],
                                      $lista[$i]['NRO_SEQUENCIAL'],
                                      $lista[$i]['QTD_VENDIDA']);
            }
        }
        return $dao->CancelarVenda();
    }
    function ReabrirVenda(){
        $dao = new OrcamentosDao();
        return $dao->ReabrirVenda();
    }

    Public Function ConsolidaOrcamento(){
        $ProdutosOrcamentosForm = new ProdutosOrcamentosForm();
        $dao = new OrcamentosDao();
        $dao->TransformaOrcamentoVenda();
        $ProdutosOrcamentosDao = new ProdutosOrcamentosDao();
        $codigo = $ProdutosOrcamentosForm->getCodProdutoVenda();
        $codigo = str_replace("'", "", $codigo);
        if ($codigo!=''){
            $codigos = explode(",", $codigo);
            if(is_array($codigos)){
                for($i=0;$i<count($codigos);$i++){
                    $cod = explode("S", $codigos[$i]);
                    $ProdutosOrcamentosDao->AtualizaProduto( $ProdutosOrcamentosForm->getCodVenda(),
                                                         $cod[1],
                                                         $cod[0]);
                    $ProdutosOrcamentosDao->AtualizaEstoque("REMOVE", $cod[0], $cod[1], $cod[2]);
                }
            }else{
                $cod = explode("S", $codigo);
                $ProdutosOrcamentosDao->AtualizaProduto( $ProdutosOrcamentosForm->getCodVenda(),
                                                     $cod[1],
                                                     $cod[0]);
                $ProdutosOrcamentosDao->AtualizaEstoque("REMOVE", $cod[0], $cod[1], $cod[2]);
            }
        }
        return true;
    }
}
?>
