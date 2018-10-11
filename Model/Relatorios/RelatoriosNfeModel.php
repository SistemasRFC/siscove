<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/RelatoriosNfeDao.php");
class RelatoriosNfeModel extends BaseModel
{
    Public Function RelatoriosNfeModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarNotasEmitidas(){
        $dao = new RelatoriosNfeDao();
        $lista = $dao->ListarNotasEmitidas($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            if ($lista[1]!=null){
                $vlrTotal = 0;
                for ($i=0;$i<count($lista[1]);$i++){
                    $vlrTotal += $lista[1][$i]["VLR_TOTAL_VENDA"];
                }
                $lista[3] = number_format($vlrTotal,2,",",".");
                $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_EMISSAO', true);
                $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENDA');
                $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_TOTAL_VENDA');
            }
        }
        return json_encode($lista);
    }
}
?>
