function ListarMetodos(classe){
    $.post('../../Controller/Menu/CadastroMenuController.php',
        {method: 'ListarMetodos',
         classe: classe,
         pastaAtual: $("#pastaAtual").val()}, function(result){                            
        result = eval('('+result+')');      
        MontaTabelaMetodos(result);
        $("#ListaMetodos").jqxWindow('open');
    });
}

function MontaTabelaMetodos(data){
    tabela = '<table>';
    tabela += '<tr>';    
    tabela += '<td>Controller</td>';
    tabela += '</tr>';
    for (i=0;i<data.length;i++){
        tabela += '<tr>';        
        tabela += '<td><a href="javascript:Utilizar(\''+data[i].dscMetodo+'\');">'+data[i].dscMetodo+'</a></td>';
        tabela += '</tr>';
    }
    tabela += '</table>';
    $("#listaMetodos").html(tabela);
}

function Utilizar(metodo){
    $("#nmeMethod").val(metodo);
    $("#ListaMetodos").jqxWindow('close');
}