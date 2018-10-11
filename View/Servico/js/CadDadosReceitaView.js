function CarregarComboCategoriaNcm(codCategoriaNcm, codNcm){ 
    $("#tdCategoriaNcm").html('');
    $("#tdCategoriaNcm").html('<div id="codCategoriaNcm"></div>');
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: [
            { name: 'COD_CATEGORIA_NCM', type: 'string'},
            { name: 'DSC_CATEGORIA_NCM', type: 'string'}
        ],
        cache: false,
        url: '../../Controller/CategoriaNcm/CategoriaNcmController.php',
        data:{method: 'ListarCategoriaNcm'}
    };    
    var dataAdapter = new $.jqx.dataAdapter(source,{ 
            loadComplete: function (records){         
            $("#codCategoriaNcm").jqxDropDownList(
            {
                source: records[1],
                theme: 'energyblue',
                width: 500,
                height: 25,
                selectedIndex: 0,
                displayMember: 'DSC_CATEGORIA_NCM',
                valueMember: 'COD_CATEGORIA_NCM'
            });           
            $("#codCategoriaNcm").val(codCategoriaNcm);
            CarregarComboNcm(codCategoriaNcm, codNcm);
        },
        async:true
    });
    $("#codCategoriaNcm").on('change', function(){
        CarregarComboNcm($(this).val());
    });
    dataAdapter.dataBind();     
}

function CarregarComboNcm(codCategoriaNcm, codNcm){ 
    $("#tdNcm").html('');
    $("#tdNcm").html('<div id="codNcm"></div>');
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: [
            { name: 'COD_NCM', type: 'string'},
            { name: 'DSC_NCM', type: 'string'}
        ],
        cache: false,
        url: '../../Controller/Ncm/NcmController.php',
        data:{method: 'ListarNcm', codCategoriaNcm: codCategoriaNcm}
    };    
    var dataAdapter = new $.jqx.dataAdapter(source,{ 
            loadComplete: function (records){         
            $("#codNcm").jqxDropDownList(
            {
                source: records[1],
                theme: 'energyblue',
                width: 500,
                height: 25,
                dropDownWidth: 700,
                selectedIndex: 0,
                displayMember: 'DSC_NCM',
                valueMember: 'COD_NCM'
            });           
            if (codNcm!=undefined){
                $("#codNcm").val(codNcm);
            }
        },
        async:true
    });
    dataAdapter.dataBind();
}