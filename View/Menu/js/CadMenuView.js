$(function() {
    $("#btnDeletar").click(function(){
        DeleteMenu(); 
    }); 
    $("#btnSalvar").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando departamento!");
        $( "#dialogInformacao" ).jqxWindow("open");
        if ($('#codMenu').val()==0){
            method = 'AddMenu';
        }else{
            method = 'UpdateMenu';
        }
        if ($("#indAtivo").is(":checked")){
            var check = 'S';
        }else{
            var check = 'N';
        }
        if ($("#indAtalho").is(":checked")){
            var checkAtalho = 'S';
        }else{
            var checkAtalho = 'N';
        }
        if ($("#imagem").val()!=""){
            var formData = new FormData($('form')[0]);
            $.ajax({
                url: '../../Controller/Menu/CadastroMenuController.php?method=uploadArquivo',
                type: 'POST',
                // Form data
                data: formData,
                //Options to tell JQuery not to process data or worry about content-type
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    data = eval('('+data+')');
                    if(data.sucesso == true){
                        $("#dscCaminhoImagem").val(data.msg);
                        $.post('../../Controller/Menu/CadastroMenuController.php',
                            {method: method,
                            codMenu: $("#codMenu").val(),
                            dscMenu: $("#dscMenu").val(),
                            nmeController: $("#nmeController").val(),
                            nmeMethod: $("#nmeMethod").val(),
                            indAtivo: check,
                            indAtalho: checkAtalho,
                            codMenuPai: $("#codMenuPai").val(),
                            dscCaminhoImagem: $("#dscCaminhoImagem").val()}, function(result){                            
                            result = eval('('+result+')');
                            if (result[0]==true){
                                $( "#dialogInformacao" ).jqxWindow('setContent', "Registro salvo com sucesso!");
                                CarregaGridMenu();
                                setTimeout(function(){
                                    $( "#dialogInformacao" ).jqxWindow("close");
                                    $( "#CadMenus" ).jqxWindow("close");
                                },"2000");
                            }else{                                
                                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Menu!'+result[1]);
                            }
                        });
                        $('#resposta').html('<img src="'+ data.msg +'" />');
                    }
                    else{
                        $('#resposta').html(data.msg);
                    }
                }
            });
        }else{
            arquivo='';
            $.post('../../Controller/Menu/CadastroMenuController.php',
                {method: method,
                codMenu: $("#codMenu").val(),
                dscMenu: $("#dscMenu").val(),
                nmeController: $("#nmeController").val(),
                nmeMethod: $("#nmeMethod").val(),
                indAtivo: check,
                indAtalho: checkAtalho,
                codMenuPai: $("#codMenuPai").val(),
                dscCaminhoImagem: $("#dscCaminhoImagem").val()}, function(data){

                data = eval('('+data+')');
                if (data[0]==1){
                    $( "#dialogInformacao" ).jqxWindow('setContent', "Registro salvo com sucesso!");
                    CarregaGridMenu();
                    setTimeout(function(){
                        $( "#dialogInformacao" ).jqxWindow("close");
                        $( "#CadMenus" ).jqxWindow("destroy");
                    },"2000");
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Menu!'+data[1]);
                }
            });
        }
    });
    
    $( "#indAtivo" ).click(function( event ) {
        if (this.checked){
            $('#indAtivo1').val('S');
        }else{
            $('#indAtivo1').val('N');
        }
    });
    $( "#indPai" ).click(function( event ) {
        if (this.checked){
            $('#indPai1').val('S');
            $('#codMenu').val('0');
        }else{
            $('#indPai1').val('N');
        }
    });
});

function MontaComboMenu(){    
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: [
            { name: 'COD_MENU_W', type: 'string'},
            { name: 'DSC_MENU_W', type: 'string'}
        ],
        cache: false,
        url: '../../Controller/Menu/CadastroMenuController.php',
        data:{
              method: 'ListarMenusGrid'
        }
    };        
    var dataAdapter = new $.jqx.dataAdapter(source,{
        loadComplete: function (records){         
            $("#codMenuPai").jqxDropDownList(
            {
                source: records[1],
                theme: 'energyblue',
                width: 200,
                height: 25,
                selectedIndex: 0,
                displayMember: 'DSC_MENU_W',
                valueMember: 'COD_MENU_W'
            });           
        },
        async:true
                     
    });  
    dataAdapter.dataBind();
   
}

function MontaTabelaArquivoMenu(codMenu){
    var theme = 'energyblue';
    var nomeGrid = 'listaArquivoMenu';    
    var source =
    {
        datatype: "json",
        type: "post",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        datafields:
        [
            { name: 'COD_ARQUIVO', type: 'string' },
            { name: 'DSC_ARQUIVO', type: 'string' },
            { name: 'NRO_PRIORIDADE', type: 'string' }
        ],
        url: '../../Controller/Menu/CadastroMenuController.php',
        data:{
            method: 'ListaArquivoMenuGrid',
            codMenu: codMenu
        }
        
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 400,
        height: 150,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: true,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Descri&ccedil;&atilde;o', datafield: 'DSC_ARQUIVO', columntype: 'textbox', width: 280}
        ]
    });
    // events
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codArquivo").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_ARQUIVO);
        $("#dscArquivo").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).DSC_ARQUIVO);
        $("#nroPrioridade").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_PRIORIDADE);
        $("#methodArquivo").val("UpdateArquivo");        
        $("#CadArquivoMenus").jqxWindow("open");
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function DeleteMenu(){    
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, removendo menu<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Menu/CadastroMenuController.php',
        {method: 'DeleteMenu',
        codMenu: $("#codMenu").val()}, function(result){                            
        result = eval('('+result+')');
        if (result[0]==true){              
            CarregaGridMenu();
            $( "#CadMenus" ).jqxWindow("close");
        }else{                                
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao deletar Menu!'+result[1]);
        }
    });
}