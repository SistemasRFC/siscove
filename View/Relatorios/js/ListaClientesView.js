$(function() {
    theme = 'energyblue';
    $("#btnPesquisa").click(function(){
        ListarDados();
    })
});

function ListaDados(){      
    $.post('../../Controller/Relatorios/RelatoriosClientesController.php', {
        method: 'DadosClientes'}, function(datai){
        data = eval('('+datai+')');            
        if (data[1]!=null){
            MontaTabela(data[1]);
        }
    });
}

function MontaTabela(data){
    codVenda=0;
    linha = '<link href="../../Resources/css/style.css" rel="stylesheet">'
    linha += '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';                
    corLinha = 'white';   
    primeira = true;
    linha = linha+'<tr>'+
    ' <tr>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         CPF\n\ '+
    '     </td>\n\ '+                        
    '     <td class="TDTitulo">\n\ '+
    '         Nome\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Telefone\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Celular\n\ '+
    '     </td>\n\ '+
    ' </tr>\n\ ';    
    for(var i=0;i<Object.keys(data).length-1;i++){                            
        if (corLinha == 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }        
        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[i].NRO_CPF+'</td>'+
            ' <td>'+data[i].DSC_CLIENTE+'</td>'+
            ' <td>'+data[i].NRO_TELEFONE_CONTATO+'</td>'+
            ' <td>'+data[i].NRO_TELEFONE_CELULAR+'</td>'+
        ' </tr>';

    }  
    linha = linha+'</table></td></tr>';
    var tmp = window.open('', 'popimpr', 'height=600,width=850');
    tmp.document.write('Listagem de Clientes');
    tmp.document.write(linha);    
    tmp.focus();
    //$("#conteudo").html(linha);
}

$(document).ready(function(){
    ListaDados();
});