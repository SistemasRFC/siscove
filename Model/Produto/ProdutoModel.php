<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Produto/ProdutoDao.php");
class ProdutoModel extends BaseModel
{
    Public Function ProdutoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarProduto($Json=true){
        $dao = new ProdutoDao();
        $lista = $dao->ListarProduto($_SESSION['cod_cliente_final']);
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

    Public Function ListarProdutosAtivos(){
        $dao = new ProdutoDao();
        $lista = $dao->ListarProdutosAtivos($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            $lista[1] = BaseModel::utf8_converter($lista[1]);
        }
        return json_encode($lista);
    }
    
    Public Function ListarProdutosVendasAutoComplete($Json=true){
        $dao = new ProdutoDao();
        $lista = $dao->ListarProdutosVendasAutoComplete($_SESSION['cod_cliente_final']);
        
        if ($lista[0]){
            $lista = BaseModel::FormataMoedaInArray($lista, "VLR_MINIMO|VLR_VENDA");
        }        
        for($i=0;$i<count($lista[1]);$i++){
            $lista[1][$i]['value']= $lista[1][$i]['value'].' Tipo: '.$lista[1][$i]['IND_TIPO_PRODUTO'].' Marca: '.$lista[1][$i]['DSC_MARCA'].' Valor: '.$lista[1][$i]['VLR_VENDA'].' Estoque: '.$lista[1][$i]['QTD_ESTOQUE'];
        }
        if($Json){
            return json_encode($lista[1]);
        }else{
            return $lista;
        }      
        
    }
    
    Public Function ListarProdutosAutoComplete($Json=true){
        $dao = new ProdutoDao();
        $lista = $dao->ListarProdutosAutoComplete($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista[1]);
        }else{
            return $lista;
        }      
        
    }
    
    Public Function AddProduto(){
        $dao = new ProdutoDao();
        $lista = $dao->VerificaProduto($_SESSION['cod_cliente_final']);
        if ($lista[1][0]['COD_PRODUTO'] > 0){
            $return[0] = false;
            $return[1] = 'Produto já cadastrado!<br>Codigo do Produto: '.$lista[1][0]['COD_PRODUTO']; 
        }else{
            $return = $dao->AddProduto($_SESSION['cod_cliente_final']);
        }
        return json_encode($return);
    }

    Public Function UpdateProduto(){
        $dao = new ProdutoDao();
        return json_encode($dao->UpdateProduto());
    }
}
?>
