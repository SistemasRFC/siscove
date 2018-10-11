function ListarController(dir){
    $.post('../../Controller/Menu/CadastroMenuController.php',
        {method: 'ListarController',
         pasta: dir}, function(result){                            
        result = eval('('+result+')');             
        MontaTabelaController(result);        
        $("#pastaAtual").val(dir);
    });
}

function MontaTabelaController(data){
    tabela = '<table>';
    tabela += '<tr>';    
    tabela += '<td>Controller</td>';
    //tabela += '<td><br></td>';
    tabela += '</tr>';
    for (i=0;i<data.length;i++){
        tabela += '<tr>';        
        tabela += '<td><a href="javascript:ListarController(\''+data[i].nmeArquivo+'\');">'+data[i].nmeArquivo+'</a></td>';
//        if (data[i].dscTipo=='file'){
//            tabela += '<td><a href="javascript:ListarMetodos(\''+data[i].nmeArquivo+'\');">Metodos</a></td>';
//        }else{
//            tabela += '<td><br></td>';
//        }
        if (data[i].dscTipo=='file'){
            tabela += '<td><a href="javascript:UtilizarController(\''+data[i].nmeArquivo+'\');">Utilizar</a></td>';
        }else{
            tabela += '<td><br></td>';
        }
        
        tabela += '</tr>';
    }
    tabela += '</table>';
    $("#listaController").html(tabela);
}

function UtilizarController(Controller){
    $("#nmeController").val($("#pastaAtual").val()+'\\'+Controller);
    $("#nmeClasse").val(Controller);
    $("#ListaController").jqxWindow('close');
}