//window.location.href='../../View/MenuPrincipal/Redirect.php';
$(document).ready(function(){
    $("input[type='button']").each(function(){
        $(this).jqxButton({theme: theme});            
    });
    $("input[type='text']").each(function(){
        $(this).jqxInput({theme: theme, height: 25});          
    }); 
});
function VerificaSessao(){
    $.post('../../Controller/MenuPrincipal/MenuPrincipalController.php', {
        async: false,
        method: 'VerificaSessao'}, function(result){
        result = eval('('+result+')');
        if (!result){            
            window.location.href='../../index.php';
        }else{
            CarregaMenu();
        }
    });
    
}
function CarregaMenu(){
    $('#CriaMenu').html('<img src="../../Resources/images/carregando.gif" width="200" height="30">');
    var DadosMenu = '';
    var theme = 'energyblue';
    $.post('../../Controller/MenuPrincipal/MenuPrincipalController.php', {
        async: false,
        method: 'CarregaMenuNew'}, function(menu){
        menu = eval('('+menu+')');
        DadosMenu = menu;
        if (DadosMenu[0]){
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', map: 'COD_MENU_W' },
                    { name: 'idPai', map: 'COD_MENU_PAI_W' },
                    { name: 'dscMenu', map: 'DSC_MENU_W' },
                    { name: 'subMenuWidth', map: 'VLR_TAMANHO_SUBMENU' }
                ],
                id: 'id',
                localdata: DadosMenu[1]
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            dataAdapter.dataBind();
            var records = dataAdapter.getRecordsHierarchy('id', 'idPai', 'items', [
                {name: 'dscMenu', map: 'label'},
                {name: 'id', map: 'id'}
            ]);
            $('#CriaMenu').jqxMenu({ source: records, height: 30, theme: theme });
            $("#CriaMenu").on('itemclick', function (event) {
                console.log(DadosMenu[1]);
                for(i=0;i<DadosMenu[1].length;i++){
                    
                    if (event.args.id==DadosMenu[1][i].COD_MENU_W){                    
                        if((DadosMenu[1][i].NME_CONTROLLER!='#') && (DadosMenu[1][i].NME_CONTROLLER!=null) && (DadosMenu[1][i].NME_CONTROLLER!='')){
                            window.location.href=DadosMenu[1][i].NME_PATH+'?method='+DadosMenu[1][i].NME_METHOD;
                        }
                    }
                }
            });
        }
    });
}

function CriarDivAutoComplete(nmeInput, url, method, dataFields, displayMember, valueMember, callback, width){ 
    if ( $("#divAutoComplete").length ){
        $("#divAutoComplete").jqxWindow("destroy");
    }
    $("#teste").html("");
    $("#teste").html('<div id="divAutoComplete"><div id="windowHeader" style="display: none;"></div><div style="overflow: hidden;" id="windowContent"><div id="listaPesquisa"></div></div> ');
    var largura = $("#"+nmeInput).width();
    if (width!=undefined){
        largura = width;
    }
    $("#divAutoComplete").jqxWindow({ 
        height: 250,
        width: largura,
        showCloseButton: false,
        maxWidth: 1200,
        position: { x: $("#"+nmeInput).offset().left, y: $("#"+nmeInput).offset().top+25 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: false,
        autoOpen: false
    });           
    $("#divAutoComplete").jqxWindow("open");
    var dados = dataFields.split('|');
    var lista = new Array();
    for (i=0;i<dados.length;i++){
        var data = new Object();
        var campos = dados[i].split(';');
        data.name = campos[1];
        lista.push(data);
    }
    var url = url;
    var source =
    {
        datatype: "json",
        datafields: lista,
        type: "POST",
        id: valueMember,
        url: url,
        data: 
            {method: method,
            term: $("#"+nmeInput).val()}
        
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxListBox
    $("#listaPesquisa").jqxListBox({ 
        source: dataAdapter, 
        displayMember: displayMember, 
        valueMember: valueMember, 
        width: largura-5, 
        height: 240
    });
    $("#listaPesquisa").on('keyup', function(event){       
       if (event.keyCode==13){
           SelecionaItem($("#listaPesquisa").jqxListBox('getSelectedItem'), dataAdapter, dataFields, callback);
       }
    });
    $("#listaPesquisa").on('select', function (event) {     
        
        if (event.args.type=='mouse'){ 
            SelecionaItem(event.args.item, dataAdapter, dataFields, callback);
        }
    });
}

function SelecionaItem(event, dataAdapter, dataFields, callback){    
    var item = event;
    if (item) {
        var x=[]       
        $.each(dataAdapter.records, function(i,n) {
            x.push(n);
        });        
        for (j=0;j<x.length;j++){
            var dados = dataFields.split('|');
            for (i=0;i<dados.length;i++){ 
                if (item.originalItem.id==x[j]['id']){
                    
                    var campos = dados[i].split(';');
                    if (campos[0]!=''){
                        $("#"+campos[0]).val(x[j][campos[1]]);
                        if ( $("#divAutoComplete").length ){
                            $("#divAutoComplete").jqxWindow("destroy");
                        }
                    }
                }
            }              
        }
        if (callback!=null){
            eval(callback);
        }                
    }
}

function CriarCombo(nmeCombo, url, parametros, dataFields, displayMember, valueMember, valor){ 
    $("#td"+nmeCombo).html('');
    $("#td"+nmeCombo).html('<div id="'+nmeCombo+'"></div>');
    var dados = dataFields.split('|');
    var lista = new Array();
    for (i=0;i<dados.length;i++){
        var data = new Object();
        data.name = dados[i];
        lista.push(data);
    }

    var dados = parametros.split('|');   
    var obj = new Object();
    for (i=0;i<dados.length;i++){
        var campos = dados[i].split(';');
        Object.defineProperty(obj, campos[0], {
                            __proto__: null,
                            enumerable : true,
                            configurable : true,
                            value: campos[1] });
    }
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: lista,
        cache: false,
        url: url,
        data: obj
    };       
    var dataAdapter = new $.jqx.dataAdapter(source,{
        loadComplete: function (records){         
            $("#"+nmeCombo).jqxDropDownList(
            {
                source: records[1],
                theme: theme,
                width: 200,
                height: 25,
                selectedIndex: 0,
                displayMember: displayMember,
                valueMember: valueMember
            }); 
            if (valor!='undefined'){
                $("#"+nmeCombo).val(valor);
            }
        },
        async:true
                     
    });  
    dataAdapter.dataBind();    
}

function CriarComboTamanho(nmeCombo, largura, altura, larguraDrop, url, parametros, dataFields, displayMember, valueMember, valor){ 
    $("#td"+nmeCombo).html('');
    $("#td"+nmeCombo).html('<div id="'+nmeCombo+'"></div>');
    var dados = dataFields.split('|');
    var lista = new Array();
    for (i=0;i<dados.length;i++){
        var data = new Object();
        data.name = dados[i];
        lista.push(data);
    }

    var dados = parametros.split('|');   
    var obj = new Object();
    for (i=0;i<dados.length;i++){
        var campos = dados[i].split(';');
        Object.defineProperty(obj, campos[0], {
                            __proto__: null,
                            enumerable : true,
                            configurable : true,
                            value: campos[1] });
    }
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: lista,
        cache: false,
        url: url,
        data: obj
    };       
    var dataAdapter = new $.jqx.dataAdapter(source,{
        loadComplete: function (records){         
            $("#"+nmeCombo).jqxDropDownList(
            {
                source: records[1],
                theme: theme,
                width: largura,
                height: altura,
                dropDownWidth: larguraDrop,
                selectedIndex: 0,
                displayMember: displayMember,
                valueMember: valueMember
            }); 
            if (valor!='undefined'){
                $("#"+nmeCombo).val(valor);
            }
        },
        async:true
                     
    });  
    dataAdapter.dataBind();    
}

$(document).ready(function(){        
    VerificaSessao();
    $("#btnFechar").click(function(){
        $("#dialogInformacao").jqxWindow('close');
    });
});