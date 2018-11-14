function GeraFile(dscTabela,nmeFile){    
        $.post("../../Controller/MontaFile/MontaFileController.php",
        {
            method: "GeraFile",
            dscTabela: dscTabela,
            nmeFile: nmeFile
        },
        function(data){
            //console.log(data);
        });
    
}


//*************************
//Autor: Gleidson Lopes Vinhal
//Data da Criação: 03/04/2014
//Alterado por: Gleidson Lopes Vinhal
//Data da última atualização: 03/04/2014
//Carrega o grid com os usuários cadastrados no banco de dados
//Controller: CadastroUsuarioController.php
//Método: ListarUsuario
//*************************
function MontaListaTabelas(){
    
    var theme = 'energyblue';
    var nomeGrid = 'listaTabelas';
    var source =
    {
        type: "post",
        datatype: "json",
        datafields:
        [            
            { name: 'NME_TABELA', datafield: 'string' }
        ],
        url:"../../Controller/MontaFile/MontaFileController.php",
        data:{
            method:"ListarTabelas"
        }
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 800,
        source: dataAdapter,
        theme: theme,
        selectionmode: 'singlerow',
        sortable: true,
        filterable: true,
        pageable: true,
        //editable: true,
        columnsresize: true,
        columns: [
          //{ text: 'C.P.F', columntype: 'textbox', datafield: 'CPF', width: 80 }, 
          { text: 'Descrição', columntype: 'textbox', datafield: 'NME_TABELA', width: 320 }
        ]
    });
    // events
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        var rows = $('#'+nomeGrid).jqxGrid('getdisplayrows');
        var rowData = rows[args.visibleindex];
        var rowID = rowData.uid;
            //GeraFile($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).Tables_in_crm)
        var nmeFile = prompt("Informe o nome do arquivo:");
        if(nmeFile){
            GeraFile($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).NME_TABELA,nmeFile);
        }else{
            alert("Nome do arquivo não informando favor tente novamente");            
        }        
    });
    //$( "#dialogInformacao" ).jqxWindow("close");     
}

$(document).ready(function () { 
    MontaListaTabelas();
    //lista();	
    //MontaTabelaUsuario();
});