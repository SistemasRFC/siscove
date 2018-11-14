<?php

class BaseModel
{
    public $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    function BaseModel(){              

    }
    
   /**
     * Converte a data que vem do banco para ser visualizada no form
     * @param <type> $data
     * @return <type>
     */
    Public Static function ConverteDataBanco($data, $hora=false){
        if ($data!='0000-00-00'){
            $dataReturn = substr($data, 8,2).'/'.substr($data, 5,2).'/'.substr($data,0,4);
            if ($hora){
                $dataReturn = $dataReturn." ".substr($data,11,8);
            }
        }else{
            $dataReturn='';
        }
        return $dataReturn;
    }
    
    Public function ConsoleLog($mensagem){
      echo "<script>console.log('$mensagem');</script>";
    }

    Public Function AddDiasData($dtaPagamento,
                                $qtdDias){
        $quebrarDatas = explode("/", $dtaPagamento);
        list($dia, $mes, $ano) = $quebrarDatas;
        $dataNova = date('d/m/Y', mktime(0,0,0, $mes, $dia + $qtdDias, $ano));
        return $dataNova;
    }

    Public Static Function diffDate($CheckIn,$CheckOut){
        $datatime1 = new DateTime($CheckIn);
        $datatime2 = new DateTime($CheckOut);

        $data1  = $datatime1->format('Y-m-d H:i:s');
        $data2  = $datatime2->format('Y-m-d H:i:s');

        $diff = $datatime1->diff($datatime2);
        $horas = $diff->h + ($diff->days * 24);

        // returns numberofdays
        return  $horas ;

    }
    
    /**
     * Cria um campo boolean, chamado ATIVO, dentro de um array passado como parï¿½metro a partir de um campo String que venha com valor S ou N
     * @param Array $lista
     * @param String $campo
     * @return Array
     */
    Public Static Function AtualizaBooleanInArray($lista, $campo, $campoNovo){
        $listaAtualizada = $lista;
        $booleans = explode('|', $campo); 
        $booleansNovo = explode('|', $campoNovo);
        for($i=0;$i<count($listaAtualizada[1]);$i++){ 
            for ($j=0;$j<count($booleans);$j++){
                if ($listaAtualizada[1][$i][$booleans[$j]]=="S"){
                    $listaAtualizada[1][$i][$booleansNovo[$j]] = true;
                }else{
                    $listaAtualizada[1][$i][$booleansNovo[$j]] = false;
                }
            }
        }        
        return $listaAtualizada;
    }
    
    /**
     * Atualiza o campo data passado como parï¿½metro dentro de um array
     * @param Array $lista
     * @param Date $campo
     * @return String
     */
    Public Static Function AtualizaDataInArray($lista, $campo, $hora=false){
        $listaAtualizada = $lista;
        $datas = explode('|', $campo);           
        for($i=0;$i<count($listaAtualizada[1]);$i++){
            for ($j=0;$j<count($datas);$j++){
                if (isset($listaAtualizada[1][$i][$datas[$j]])){
                    $listaAtualizada[1][$i][$datas[$j]] = BaseModel::ConverteDataBanco($listaAtualizada[1][$i][$datas[$j]], $hora);
                }
            }
        }
        return $listaAtualizada;
    }
    
    Public Static Function FormataMoedaInArray($lista, $campo){
        $listaAtualizada = $lista;
        $datas = explode('|', $campo);        
        for($i=0;$i<count($listaAtualizada[1]);$i++){
            for ($j=0;$j<count($datas);$j++){
                if (isset($listaAtualizada[1][$i][$datas[$j]])){
                    $listaAtualizada[1][$i][$datas[$j]] = number_format($listaAtualizada[1][$i][$datas[$j]],2,",",".");
                }
            }
        }
        return $listaAtualizada;        
    }
    
    Public Static Function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }   
    
    Public Static Function validaCPF($cpf = null) {
        $arrRepetidos = array('00000000000', '11111111111', '22222222222', '33333333333',
            '44444444444', '55555555555', '66666666666', '77777777777',
            '88888888888', '99999999999');
        if (empty($cpf)) {
            return false;
        }
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        if (strlen($cpf) != 11) {
            return false;
        }else if (in_array($cpf, $arrRepetidos)) {
            return false;
        } else {
            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
            return true;
        }
    }

}
?>
