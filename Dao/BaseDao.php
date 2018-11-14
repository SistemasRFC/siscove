<?php
class BaseDao{
    /*Método construtor do banco de dados*/
    public function BaseDao(){
        self::conect();
    }    
    
    Public Function __destruct() {
        self::disconnect();
    }
    private static $dbtype   = "mysql";
    private static $host     = "localhost";
    private static $port     = PORT;
    private static $user     = USER;
    private static $password = PASSWORD;
    private static $conexao  = CONEXAO;
    private static $db       = DB;
    public static $qtdRegistros = 0;
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    private static function getDBType()  {return self::$dbtype;}
    private static function getHost()    {return self::$host;}
    private static function getPort()    {return self::$port;}
    private static function getUser()    {return self::$user;}
    private static function getPassword(){return self::$password;}
    private static function getDB()      {return self::$db;}

    Static function conect(){
        try{
            //self::$conexao = mysqli_connect(self::getHost(),self::getUser(),self::getPassword());  
            if (self::$conexao==null){
                self::$conexao = new mysqli(self::getHost(), self::getUser(), self::getPassword(), self::getDB());
                if(mysqli_connect_errno()){          
                    print "Ocorreu um Erro na conexão MySQL:<b>".mysql_error()."</b>";
                    die();
                }
            }
        }catch(Exception $e){
            print "<b>".mysql_error()."</b>";
        }
    }

    private Static function disconnect(){
        self::$conexao = null;
    }
    /**
     * Método select que retorna um array de objetos
     */
    public Static function selectDB($sql, $objeto=true){
        self::conect();    
        $resultado = mysqli_query(self::$conexao, $sql);
        if (!$resultado){
            $resulta[0] = false;
            $resulta[1] = " Erro: ".  mysqli_error(self::$conexao)."SQL: ".$sql;
            //self::disconnect();
        }else if($resultado){
            //self::disconnect();
            if ($objeto){    
                $resulta[0] = true;
                $resulta[1] = mysqli_fetch_object($resultado);
            }else{
                $resulta[0] = true;
                $resulta[1] = self::CarregaArray($resultado);
            }
        }
        return $resulta;
    }

    /**
     * Recebe um ResultSet e tranforma em um Array
     * @param ResultSet $array
     * @return Array
     */
    Private Static Function CarregaArray($array){
        $i=0;
        while ($rs = mysqli_fetch_array($array)){
            $resulta[$i] = $rs;
            $i++;
        }
        if(!isset($resulta)){
            $resulta = null;
        }        
        return $resulta;
    }
    /*Método insert que insere valores no banco de dados e retorna o último id inserido*/
    public static function insertDB($sql){
        self::conect();
        if (mysqli_query(self::$conexao, $sql)){
            $result[0] = true;
            $result[1] = 'sucesso';
            $result[2] = mysqli_insert_id(self::$conexao);
        }else{
            $result[0] = false;
            $result[1] = mysqli_error(self::$conexao)."<br>".$sql;
        }
        //self::disconnect();
        return $result;
    }
    /*Método insert que insere valores no banco de dados e retorna o último id inserido*/
    public static function updateDB($sql, $id){
        self::conect();
        if (mysqli_query(self::$conexao, $sql)){
            $result[0] = true;
            $result[1] = 'sucesso';
            $result[2] = $id;
        }else{
            $result[0] = false;
            $result[1] = mysqli_error(self::$conexao)."<br>".$sql;
        }
        self::disconnect();
        return $result;
    }

    /**
     * Cria um objeto a partir de uma array
     * @param type $array
     * @return type
     */
    Public Function IniciaTransacao(){
        mysqli_begin_transaction(self::$conexao);
    }
    
    Public Function ComitaTransacao(){
        mysqli_commit(self::$conexao);
    }
    
    Public Function RolbackTransacao(){
        mysqli_rollback(self::$conexao);
    }
    
    public function getObject($array){
        if (isset($array[0])){
            return (object)$array[0];
        }else{
            return null;
        }
    }

    /**
     *  Pega o último código da tabela passada por parametro e acrescenta mais 1
     * @param <type> $tabela
     * @param <type> $codigo
     * @return <type>
     */
    static function CatchUltimoCodigo($tabela, $codigo){
        $sql = "
        SELECT COALESCE(MAX(".$codigo."),0)+1 AS ".$codigo." FROM ".$tabela;   
        $rs = self::selectDB($sql, false);
        if (!empty($rs)){
            return $rs[1][0][$codigo];
        }else{
            return 1;
        }
    }

    /**
     * Converte a data que vem do form para ser inserida no banco
     * @param <type> $data
     * @return <type>
     */
    function ConverteDataForm($data){
        if ($data!=''){
            $data = substr($data, 6,4).'-'.substr($data, 3,2).'-'.substr($data, 0,2);
        }else{
            $data='';
        }
        return $data;
    }

    Public Function GetDataAtual(){
        $sql = "SELECT NOW() AS DATA_ATUAL";
        $rs = $this->selectDB($sql, false);
        return $rs[0]['DATA_ATUAL'];
    }
    
    /**
     * 
     * @param type $codLoja
     */
    Public Function MontarInsert($codLoja=NULL){
        if ($this->columnKey){
            $columnKey = $this->CatchUltimoCodigo($this->tableName, $this->columnKey[key($this->columnKey)]['column']);
            $fields = '('.$this->columnKey[key($this->columnKey)]['column'].', ';
            $values = 'VALUES ('.$columnKey.', ';
        }else{
            $fields = '(';
            $values = 'VALUES (';
            $columnKey = 0;
        }
        if (!empty($codLoja)){
            $fields .= 'COD_LOJA, ';
            $values .= $codLoja.', ';
        }
        foreach($_POST as $key => $value){
            foreach($this->columns as $keyc => $valuec){                
                if ($keyc == $key){
                    $fields .= $valuec['column'].', ';
                    if ($valuec['typeColumn']=='S'){
                        $values .= "'".$value."', ";
                    }else if ($valuec['typeColumn']=='F'){
                        $values .= "'".str_replace(",", ".", str_replace(".", "", $value))."', ";
                    }else if ($valuec['typeColumn']=='D'){
                        $values .= "'".$this->ConverteDataForm($value)."', ";
                    }else if ($valuec['typeColumn']=='DT'){
                        $values .= "'".$this->ConverteDataForm($value, true)."', ";
                    }else{
                        $values .= $value.', ';
                    }
                    
                }
            }
        }
        $fields = substr($fields, 0, strlen($fields)-2).')';
        $values = substr($values, 0, strlen($values)-2).')';
        $sql = "INSERT INTO ".$this->tableName." ".$fields." ".$values;
        $return = $this->insertDB($sql);
        $return[2] = $columnKey;
        return $return;
    }
    
    Public Function MontarUpdate(){
        $values = ' SET ';
        foreach($_POST as $key => $value){
            foreach($this->columns as $keyc => $valuec){                
                if ($keyc == $key){
                    if ($valuec['typeColumn']=='S'){
                        $values .= $valuec['column']." = '".$value."', ";
                    }else if ($valuec['typeColumn']=='F'){
                        $values .= $valuec['column']." = '".str_replace(",", ".", str_replace(".", "", $value))."', ";
                    }else if ($valuec['typeColumn']=='D'){
                        $values .= $valuec['column']." = '".$this->ConverteDataForm($value)."', ";
                    }else if ($valuec['typeColumn']=='DT'){
                        $values .= $valuec['column']." = '".$this->ConverteDataForm($value, true)."', ";
                    }else{
                        $values .= $valuec['column']." = ".$value.", ";
                    }
                    
                }
            }
        }
        $values = substr($values, 0, strlen($values)-2).' 
                WHERE '.$this->columnKey[key($this->columnKey)]['column'].' = '.$this->Populate(key($this->columnKey), 'I');
        $sql = "UPDATE ".$this->tableName." ".$values;
        return $this->updateDB($sql, $this->Populate(key($this->columnKey)));      
    }
    
    Public Function MontarSelect($codLoja=NULL, $criterio=NULL, $ordenacao=NULL){
        $sql = 'SELECT '.$this->columnKey[key($this->columnKey)]['column'].', ';
        foreach($this->columns as $key => $value){
            if ($value['typeColumn']=='I'){
                $sql .= 'COALESCE('.$value['column'].', -1) AS '.$value['column'].', ';
            }else{
                $sql .= $value['column'].', ';
            }
        }
        $sql = substr($sql, 0, strlen($sql)-2).' FROM '.$this->tableName;
        if ($codLoja){
            $sql .= " WHERE COD_LOJA = ".$codLoja;
        }
        if ($criterio){
            $sql .= " ".$criterio;
        }
        if ($ordenacao){
            $sql .= " ".$ordenacao;
        }
//        echo $sql;
        return $this->selectDB($sql, false);
    }
    
    Public Function MontarSelectAtivos($codLoja=NULL, $criterio=NULL, $ordenacao=NULL){
        $sql = 'SELECT '.$this->columnKey[key($this->columnKey)]['column'].', ';
        foreach($this->columns as $key => $value){
            $sql .= $value['column'].', ';
        }
        $sql = substr($sql, 0, strlen($sql)-2).' FROM '.$this->tableName." WHERE IND_ATIVO='S'";
        if ($codLoja){
            $sql .= " AND COD_LOJA = ".$codLoja;
        } 
        if ($criterio){
            $sql .= " ".$criterio;
        }
        if ($ordenacao){
            $sql .= " ".$ordenacao;
        }       
        return $this->selectDB($sql, false);
    }

    Public function Pivot1($tabela,
                         $tabelaPivot,
                         $campoPivot,
                         $outrosCampos,
                         $campoCont,
                         $alias,
                         $criterioPivot,
                         $criterioSelect,
                         $campoSomar){
        if ($tabelaPivot==''){
            $tabelaPivotear=$tabela;
        }else{
            $tabelaPivotear=$tabelaPivot;
        }
        $sql_group = "SELECT $campoPivot AS $campoPivot
                        FROM $tabelaPivotear
                        $criterioPivot
                       GROUP BY $campoPivot";
        $result_group = $this->selectDB($sql_group, false);
        $result_group = $result_group[1];
        $colunas='';
        for ($i=0;$i<count($result_group);$i++){
            if ($colunas==''){
                $colunas=''.$result_group[$i][$campoPivot];
            }else{
                $colunas=$colunas.','.$result_group[$i][$campoPivot];
            }
            $colunas.=' ';
        }
        if ($outrosCampos!=''){
            $sql_montada = "SELECT $outrosCampos,
                                   $campoCont as $alias";
        }else{
            $sql_montada = "SELECT $campoCont as $alias";
        }
        $j=0;
        $tamanho = strlen($colunas);
        while ($j<$tamanho){
            $palavra='';
            $palavra = $this->pegaPalavra($colunas, $j, $tamanho);
            $j=$j+strlen($palavra)+1;
            $sql_montada.=", SUM(CASE WHEN $campoPivot='$palavra' THEN $campoSomar ELSE 0 END) AS '$palavra'";
        }
        $sql_montada.= " FROM $tabela";
        if ($criterioSelect!=''){
            $sql_montada .= " $criterioSelect";
        }
        if ($outrosCampos!=''){
            $sql_montada .= " GROUP BY $outrosCampos, $campoCont
                              ORDER BY $outrosCampos, $campoCont";
        }
        return $sql_montada;
    }

    Public Function pegaPalavra($Texto, $inicio, $tamanho){
        $j=$inicio;
        $palavra='';
        while (($Texto[$j]!=',')&&
              ($j+1<$tamanho)){
            $palavra=$palavra.$Texto[$j];
            $j=$j+1;
        }
        return $palavra;
    }

    Public function IsDesenv($codUsuario){        
        $sql_lista = "SELECT COALESCE(COUNT(*),0) AS QTD
                        FROM SE_USUARIO U 
                      WHERE COD_USUARIO = $codUsuario"
                . "     AND COD_PERFIL_W = 1";
        $lista = $this->selectDB("$sql_lista", false);
        
        return $lista[1][0]['QTD'];
    }
    
    /**
     * $type = 'S' - FILTER_SANITIZE_STRING
     *       = 'I' - FILTER_SANITIZE_NUMBER_INTEGER
     *       = 'F' - FILTER_SANITIZE_NUMBER_FLOAT
     *       = 'D' - FILTER_SANITIZE_STRING (formatado para data)
     * @param type $field
     * @param type $type
     * @return type
     */
    Public Function Populate($field, $type='S'){
        $array = array('S' => FILTER_SANITIZE_STRING,
                       'I' => FILTER_SANITIZE_NUMBER_INT,
                       'F' => FILTER_SANITIZE_NUMBER_FLOAT,
                       'D' => FILTER_SANITIZE_STRING);
        if ($type=='F'){
            $return = filter_input(INPUT_POST, $field);
            $return = str_replace(",", ".", str_replace(".", "", $return));
        }else if ($type=='D'){
            $return = $this->ConverteDataForm(filter_input(INPUT_POST, $field, $array[$type]));
        }else{
            $return = filter_input(INPUT_POST, $field, $array[$type]);
        }
        return $return;
    }
}
?>
