<script src="../../View/Cliente/js/CadClienteView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="codCliente" id="codCliente" value="0">
<input type="hidden" name="codIbge" id="codIbge">
<input type="hidden" name="codGia" id="codGia">
<input type="hidden" name="txtUnidade" id="txtUnidade">
<table width="100%" align="left">
    <tr>
        <td>
            <table width="100%" align="left" border="0">
                <tr>
                    <td>Digite o nome do Cliente</td>
                </tr>
                <tr>
                    <td><input type="text" size="79" name="dscCliente" value="" id="dscCliente" ></td>
                </tr>
            </table>
        </td>
    </tr>  
    <tr>
        <td>
            <table width="100%" align="left" border="0">
                <tr>
                    <td width="15%">Data de Nascimento</td>
                    <td width="65%">Email</td>
                </tr>
                <tr>
                    <td><div id="dtaNascimento"></div></td>      
                    <td><input type="text" size="59" maxlength="100" name="txtEmail" id="txtEmail" value=""></td>
                </tr>
            </table>
        </td>
    </tr>     
    <tr>
        <td>
            <table width="100%" align="left" border="0">
                </tr>
                <tr>
                    <td width="150">Telefone</td>
                    <td width="150">Telefone Celular</td>
                    <td width="150">Tipo de pessoa</td>
                    <td width="150" class="trCPF">CPF</td>
                    <td width="150" class="trCNPJ">I.E.</td>
                </tr>
                <tr>
                    <td><input type="text" size="14" maxlength="14" name="fone" id="fone" value="" onkeypress="return txtBoxFormat(this, '(99)99999-9999', event);"></td>                
                    <td><input type="text" size="14" maxlength="14" name="foneCelular" id="foneCelular" value="" onkeypress="return txtBoxFormat(this, '(99)99999-9999', event);"></td>
                    <td><div id="comboCodTipoPessoa"></div>
                    <select name="codTipoPessoa" id="codTipoPessoa" style="display:none">
                        <option value="-1">Selecione</option>
                        <option value="F">Física</option>
                        <option value="J">Jurídica</option>
                    </select> 
                    <td align="left">
                        <input type="text" size="18" maxlength="14" name="nroCpf" id="nroCpf" value="" onkeypress="return txtBoxFormat(this, '999.999.999-99', event);">
                        <input type="text" size="18" maxlength="18" name="nroCnpj" id="nroCnpj" value="" onkeypress="return txtBoxFormat(this, '99.999.999/9999-99', event);">             
                    </td> 
                    <td>
                        <input type="text" class="trCNPJ" size="18" maxlength="18" name="nroIe" id="nroIe" value="" onkeypress="return txtBoxFormat(this, '99.999.999/999-99', event);">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>CEP</td>
                    <td>Logradouro</td>
                    <td>Complemento</td>
                    <td>Bairro</td>
                </tr>
                <tr>
                    <td><input type="text" size="10" maxlength="10" name="nroCep" id="nroCep" value="" onkeypress="return txtBoxFormat(this, '99.999-999', event);"></td>
                    <td><input type="text" size="19" id="txtLogradouro"></td>
                    <td><input type="text" size="19" id="txtComplemento"></td>
                    <td><input type="text" size="20" id="nmeBairro"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Cidade</td>
                    <td>UF</td>
                </tr>
                <tr>
                    <td><input type="text" id="nmeCidade"></td>
                    <td><div id="sglUf"></div></td>
                </tr>
            </table>
        </td>
    </tr>    
    <tr>
        <td>
            <table>                
                <tr>
                    <td colspan="2"><input type="button" id="btnSalvarCliente" value="Salvar">
                        <input type="button" id="btnVendasCliente" value="Vendas deste cliente">
                        <input type="button" id="btnRelVendasCliente" value="Relatório de vendas deste cliente">
                        <!--<input type="button" id="btnDeletarCliente" value="Deletar"></td>-->
                </tr>  
            </table>
        </td>
    </tr>
</table> 
<div id="VendasForm">
      <div id="windowHeader">
      </div>
      <div style="overflow: hidden;" id="windowContent">
          <table>
              <tr>
                  <td id="tdListaVendaCliente">
                      <div id="ListaVendaCliente"></div>
                  </td>
              </tr>
          </table>
      </div>            
</div>      