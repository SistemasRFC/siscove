$(function() {
    $("#CadMenus").jqxWindow({ 
        title: 'Cadastro de Menus',
        height: 450,
        width: 700,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });

    $("#btnDeletar").click(function(){
        DeleteMenu(); 
    });
    $("#btnNovo").click(function(){
        $("#codMenu").val(0);
        $("#dscMenu").val('');
        $("#nmeController").val('');
        $("#nmeMethod").val('');
        $("#dscCaminhoImagem").val('');
        $("#codMenuPai").val(0);
        $("#indAtivo").prop("checked", false);
        $("#indAtalho").prop("checked", false);
        $("#CadMenus").jqxWindow("open");
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
                url: '../../Controller/Seguranca/CadastroMenuController.php?method=uploadArquivo',
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
                        $.post('../../Controller/Seguranca/CadastroMenuController.php',
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
            $.post('../../Controller/Seguranca/CadastroMenuController.php',
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
                        $( "#CadMenus" ).jqxWindow("close");
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
function CarregaGridMenu(){
    $("#tdMenus").html("");
    $("#tdMenus").html('<div id="listaMenus"></div>');
    $('#listaMenus').html("<img src='../../Resources/images/carregando.gif' width='200' height='30'>");
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, carregando grid!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");     
    $.post('../../Controller/Seguranca/CadastroMenuController.php',
           {
               method: 'ListarMenusGrid'
           },
           function(listaMenus){
                listaMenus = eval ('('+listaMenus+')');
                MontaTabelaMenu(listaMenus[1]);
           }
    );
}
function MontaTabelaMenu(listaMenus){
    var nomeGrid = 'listaMenus';
    var contextMenu = $("#jqxMenu").jqxMenu({ width: '120px', autoOpenPopup: false, mode: 'popup', theme: theme });
    var source =
    {
        localdata: listaMenus,
        datatype: "json",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        datafields:
        [
            { name: 'COD_MENU_W', type: 'string' },
            { name: 'DSC_MENU_W', type: 'string' },
            { name: 'NME_CONTROLLER', type: 'string' },
            { name: 'NME_METHOD', type: 'string' },
            { name: 'DSC_CAMINHO_IMAGEM', type: 'string' },
            { name: 'COD_MENU_PAI_W', type: 'string' },
            { name: 'ATIVO', type: 'boolean' },
            { name: 'ATALHO', type: 'boolean' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 400,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: true,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'C&oacute;digo', columntype: 'textbox', datafield: 'COD_MENU_W', width: 80},
          { text: 'Descri&ccedil;&atilde;o', datafield: 'DSC_MENU_W', columntype: 'textbox', width: 180},
          { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 67 },
          { text: 'Atalho', datafield: 'ATALHO', columntype: 'checkbox', width: 67 }
        ]
    });
    // events
    $('#'+nomeGrid).on('rowclick', function (event)
    {
        var args = event.args;
        var rows = $('#'+nomeGrid).jqxGrid('getdisplayrows');
        var rowData = rows[args.visibleindex];
        var rowID = rowData.uid;
        if (event.args.rightclick) {

            $("#listaMenus").jqxGrid('selectrow', event.args.rowindex);
            var scrollTop = $(window).scrollTop();
            var scrollLeft = $(window).scrollLeft();
            contextMenu.jqxMenu('open', parseInt(event.args.originalEvent.clientX) + 5 + scrollLeft, parseInt(event.args.originalEvent.clientY) + 5 + scrollTop);
            $("#codMenu").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).COD_MENU_W);
            $("#dscMenu").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).DSC_MENU_W);
            $("#nmeController").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).NME_CONTROLLER);
            $("#nmeMethod").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).NME_METHOD);
            $("#dscCaminhoImagem").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).DSC_CAMINHO_IMAGEM);
            $("#codMenuPai").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).COD_MENU_PAI_W);
            $("#indAtivo").prop("checked", $('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).ATIVO);
            $("#indAtalho").prop("checked", $('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).ATALHO);
            return false;
        }        
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        var rows = $('#'+nomeGrid).jqxGrid('getdisplayrows');
        var rowData = rows[args.visibleindex];
        var rowID = rowData.uid;
        $("#codMenu").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).COD_MENU_W);
        $("#dscMenu").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).DSC_MENU_W);
        $("#nmeController").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).NME_CONTROLLER);
        $("#nmeMethod").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).NME_METHOD);
        $("#dscCaminhoImagem").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).DSC_CAMINHO_IMAGEM);
        $("#codMenuPai").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).COD_MENU_PAI_W);
        $("#indAtivo").prop("checked", $('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).ATIVO);
        $("#indAtalho").prop("checked", $('#'+nomeGrid).jqxGrid('getrowdatabyid', rowID).ATALHO);
        $("#method").val("UpdateMenu");
        $("#CadMenus").jqxWindow("open");
    });
    $("#jqxMenu").on('itemclick', function (event) {
        var args = event.args;
        var rowindex = $("#listaMenus").jqxGrid('getselectedrowindex');
        if ($.trim($(args).text()) == "Editar") {           
            $("#CadMenus").jqxWindow("open");
            //$("#CadMenus").dialog("open");
        }else if($.trim($(args).text()) == "Novo"){
            $("#codMenu").val(0);
            $("#dscMenu").val('');
            $("#nmeController").val('');
            $("#nmeMethod").val('');
            $("#dscCaminhoImagem").val('');
            $("#codMenuPai").val(0);
            $("#indAtivo").prop("checked", false);
            $("#indAtalho").prop("checked", false);
            $("#CadMenus").jqxWindow("open");
        }
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}
$(document).ready(function(){
    CarregaGridMenu();
    $(document).on('contextmenu', function (e) {
        return false;
    });
    $("input[type='button']").button();
});

function DeleteMenu(){    
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, removendo menu<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Seguranca/CadastroMenuController.php',
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