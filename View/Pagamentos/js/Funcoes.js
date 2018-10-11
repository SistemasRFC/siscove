var totalValor = 0;
function MontaComboFixo(nmeCombo, nmeSelect, seleciona){
    $("#"+nmeCombo).jqxDropDownList({ width: '200px', height: '25px'});
    $("#"+nmeCombo).jqxDropDownList('loadFromSelect', nmeSelect);  
    $("#"+nmeSelect).val(seleciona);
    var index = $("#"+nmeSelect)[0].selectedIndex;
    $("#"+nmeCombo).jqxDropDownList('selectIndex', index);
    $("#"+nmeCombo).jqxDropDownList('ensureVisible', index);    
    
    $("#"+nmeCombo).on('select', function (event) {
        var args = event.args;
        // select the item in the 'select' tag.
        var index = args.item.index;
        $("#"+nmeSelect).val(args.item.value);
        
    });  
    $("#"+nmeSelect).on('change', function (event) {
        updating = true;
        $("#"+nmeSelect).val(seleciona);
        var index = $("#"+nmeSelect)[0].selectedIndex;
        $("#"+nmeCombo).jqxDropDownList('selectIndex', index);
        $("#"+nmeCombo).jqxDropDownList('ensureVisible', index);
        updating = false;
    });    
}

function AtualizaValores(soma){
    soma = String(soma);
    soma = soma.replace(',','');
    soma = soma.replace(',','.');   
    totalValor = String(totalValor);
    totalValor = totalValor.replace(',',''); 
    totalValor = totalValor.replace(',','.');             
    total = totalValor;
    total = parseFloat(total)-parseFloat(soma);      
    soma = Formata(soma,2,'.',',');
    total = Formata(total,2,'.',',');     
    $("#vlrSelecionado").html(soma);
    $("#vlrTotal").html(total);
}