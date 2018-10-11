$(document).ready(function(){
    $('#jqxTabsProdutos').jqxTabs({ width: '100%', position: 'top'});
    $('#jqxTabsProdutos').jqxTabs({ selectionTracker: true, disabled:false});
    $('#jqxTabsProdutos').jqxTabs({ animationType: 'fade' });    
    CriarCombo('codMarca', 
               '../../Controller/Marca/MarcaController.php', 
               'method;ListarMarcasAtivas', 
               'COD_MARCA|DSC_MARCA', 
               'DSC_MARCA', 
               'COD_MARCA');     
    CriarCombo('codTipoProduto', 
               '../../Controller/TipoProduto/TipoProdutoController.php', 
               'method;ListarTipoProdutosAtivos', 
               'COD_TIPO_PRODUTO|DSC_TIPO_PRODUTO', 
               'DSC_TIPO_PRODUTO', 
               'COD_TIPO_PRODUTO');   
    CriarComboTamanho('codCfop', 500, 20, 700,
               '../../Controller/Cfop/CfopController.php', 
               'method;ListarCfop', 
               'COD_CFOP|DSC_APLICACAO', 
               'DSC_APLICACAO', 
               'COD_CFOP');  
    CriarComboTamanho('codIcmsOrigem', 500, 20, 700,
               '../../Controller/IcmsOrigem/IcmsOrigemController.php', 
               'method;ListarIcmsOrigem', 
               'COD_ICMS_ORIGEM|DSC_ICMS_ORIGEM', 
               'DSC_ICMS_ORIGEM', 
               'COD_ICMS_ORIGEM');  
    CarregarComboCategoriaNcm();   
    CriarComboTamanho('codIcmsSituacaoTributaria', 500, 20, 700,
               '../../Controller/IcmsSituacaoTributaria/IcmsSituacaoTributariaController.php', 
               'method;ListarIcmsSituacaoTributaria', 
               'COD_ICMS_SITUACAO_TRIBUTARIA|DSC_ICMS_SITUACAO_TRIBUTARIA', 
               'DSC_ICMS_SITUACAO_TRIBUTARIA', 
               'COD_ICMS_SITUACAO_TRIBUTARIA');  
    CriarComboTamanho('codPisSituacaoTributaria', 500, 20, 700,
               '../../Controller/PisSituacaoTributaria/PisSituacaoTributariaController.php', 
               'method;ListarPisSituacaoTributaria', 
               'COD_PIS_SITUACAO_TRIBUTARIA|DSC_PIS_SITUACAO_TRIBUTARIA', 
               'DSC_PIS_SITUACAO_TRIBUTARIA', 
               'COD_PIS_SITUACAO_TRIBUTARIA');   
    CriarComboTamanho('codCofinsSituacaoTributaria', 500, 20, 700,
               '../../Controller/CofinsSituacaoTributaria/CofinsSituacaoTributariaController.php', 
               'method;ListarCofinsSituacaoTributaria', 
               'COD_COFINS_SITUACAO_TRIBUTARIA|DSC_COFINS_SITUACAO_TRIBUTARIA', 
               'DSC_COFINS_SITUACAO_TRIBUTARIA', 
               'COD_COFINS_SITUACAO_TRIBUTARIA');     
});