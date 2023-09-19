<?php
/* Smarty version 3.1.34-dev-7, created on 2023-02-02 10:27:31
  from '/akasa/www/marketing/templates/socketform.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63db90136dbac8_30133941',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '20e234186da21d13e98e1c56ec16f0f26adaeae5' => 
    array (
      0 => '/akasa/www/marketing/templates/socketform.tpl',
      1 => 1664367825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63db90136dbac8_30133941 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '154350218063db90136da965_39244371';
?>
<!-- Begin of Sockets Form Dialog -->
<div  class="easyui-dialog" id="socketformdlg"  data-options="resizable:true" style="width:830px;height:570px;padding:10px 20px" closed="true"  buttons="#dlg-buttons" title="Edit Cooler Sockets">
      <form id="socketform" method="post">
      <input type="text" name="partno" hidden=true value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
<fieldset>
<legend><b>Intel Sockets:</b></legend>
<input type="checkbox" class="easyui-checkbox" id="s370_id" name="isockets[]" label="Socket 370" labelAlign="left" labelPosition="after" labelwidth="100" value="s370">
<input type="checkbox" class="easyui-checkbox" id="s478_id" name="isockets[]" label="Socket 478" labelAlign="left" labelPosition="after" labelwidth="100" value="s478">
<input type="checkbox" class="easyui-checkbox" id="s603_id" name="isockets[]" label="Socket 603" labelAlign="left" labelPosition="after" labelwidth="100" value="s603">
<input type="checkbox" class="easyui-checkbox" id="s604_id" name="isockets[]" label="Socket 604" labelAlign="left" labelPosition="after" labelwidth="100" value="s604">
<input type="checkbox" class="easyui-checkbox" id="s771_id" name="isockets[]" label="LGA771" labelAlign="left" labelPosition="after" labelwidth="100" value="s771">
<input type="checkbox" class="easyui-checkbox" id="s775_id" name="isockets[]" label="LGA775" labelAlign="left" labelPosition="after" labelwidth="100" value="s775">
<p>
<input type="checkbox" class="easyui-checkbox" id="s1155_id" name="isockets[]" label="LGA1155" labelAlign="left" labelPosition="after" labelwidth="100" value="s1155">
<input type="checkbox" class="easyui-checkbox" id="s1156_id" name="isockets[]" label="LGA1156" labelAlign="left" labelPosition="after" labelwidth="100" value="s1156">
<input type="checkbox" class="easyui-checkbox" id="s115X_id" name="isockets[]" label="LGA115x" labelAlign="left" labelPosition="after" labelwidth="100" value="s115X">
<input type="checkbox" class="easyui-checkbox" id="s1200_id" name="isockets[]" label="LGA1200" labelAlign="left" labelPosition="after" labelwidth="100" value="s1200">
<input type="checkbox" class="easyui-checkbox" id="s1700_id" name="isockets[]" label="LGA1700" labelAlign="left" labelPosition="after" labelwidth="100" value="s1700">
<p>
<input type="checkbox" class="easyui-checkbox" id="s1356_id" name="isockets[]" label="LGA1356" labelAlign="left" labelPosition="after" labelwidth="100" value="s1356">
<input type="checkbox" class="easyui-checkbox" id="s1366_id" name="isockets[]" label="LGA1366" labelAlign="left" labelPosition="after" labelwidth="100" value="s1366">
<p>
<input type="checkbox" class="easyui-checkbox" id="s2011_id" name="isockets[]" label="LGA2011" labelAlign="left" labelPosition="after" labelwidth="100" value="s2011">
<input type="checkbox" class="easyui-checkbox" id="s2066_id" name="isockets[]" label="LGA2066" labelAlign="left" labelPosition="after" labelwidth="100" value="s2066">
<p>
<input type="checkbox" class="easyui-checkbox" id="s3647s_id" name="isockets[]" label="LGA3647 Square" labelAlign="left" labelPosition="after" labelwidth="140" value="s3647s">
<input type="checkbox" class="easyui-checkbox" id="s3647n_id" name="isockets[]" label="LGA3647 Narrow" labelAlign="left" labelPosition="after" labelwidth="140" value="s3647n">
</fieldset>
<p>
<fieldset>
<legend><b>AMD Sockets:</b></legend>
<input type="checkbox" class="easyui-checkbox" id="sa_id" name="isockets[]" label="Socket A:" labelAlign="left" labelPosition="after" labelwidth="100" value="sa">
<input type="checkbox" class="easyui-checkbox" id="s754_id" name="isockets[]" label="Socket 754" labelAlign="left" labelPosition="after" labelwidth="140" value="s754">
<input type="checkbox" class="easyui-checkbox" id="s939_id" name="isockets[]" label="Socket 939" labelAlign="left" labelPosition="after" labelwidth="100" value="s939">
<input type="checkbox" class="easyui-checkbox" id="s940_id" name="isockets[]" label="Socket 940" labelAlign="left" labelPosition="after" labelwidth="140" value="s940">
<input type="checkbox" class="easyui-checkbox" id="s1207_id" name="isockets[]" label="Socket 1207" labelAlign="left" labelPosition="after" labelwidth="100" value="s1207">
<p>
<input type="checkbox" class="easyui-checkbox" id="sam2_id" name="isockets[]" label="Socket AM2" labelAlign="left" labelPosition="after" labelwidth="100" value="sam2">
<input type="checkbox" class="easyui-checkbox" id="sam2plus_id" name="isockets[]" label="Socket AM2 Plus" labelAlign="left" labelPosition="after" labelwidth="140" value="sam2plus">
<input type="checkbox" class="easyui-checkbox" id="sam3_id" name="isockets[]" label="Socket AM3" labelAlign="left" labelPosition="after" labelwidth="100" value="sam3">
<input type="checkbox" class="easyui-checkbox" id="sam3plus_id" name="isockets[]" label="Socket AM3 Plus" labelAlign="left" labelPosition="after" labelwidth="140" value="sam3plus">
<input type="checkbox" class="easyui-checkbox" id="sam4_id" name="isockets[]" label="Socket AM4" labelAlign="left" labelPosition="after" labelwidth="100" value="sam4">
<p>
<input type="checkbox" class="easyui-checkbox" id="sg34_id" name="isockets[]" label="Socket G34" labelAlign="left" labelPosition="after" labelwidth="100" value="sg34">
<p>
<input type="checkbox" class="easyui-checkbox" id="sfm1_id" name="isockets[]" label="Socket FM1" labelAlign="left" labelPosition="after" labelwidth="100" value="sfm1">
<input type="checkbox" class="easyui-checkbox" id="sfm2_id" name="isockets[]" label="Socket FM2" labelAlign="left" labelPosition="after" labelwidth="100" value="sfm2">
<input type="checkbox" class="easyui-checkbox" id="sfm2plus_id" name="isockets[]" label="Socket FM2 Plus" labelAlign="left" labelPosition="after" labelwidth="140" value="sfm2plus">
<p>
<input type="checkbox" class="easyui-checkbox" id="sfs1b_id" name="isockets[]" label="Socket FS1b" labelAlign="left" labelPosition="after" labelwidth="100" value="sfs1b">
</fieldset>
      </form>
  <div style="text-align:center;padding:5px 0">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitSocketForm()" style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelSocketForm()" style="width:80px">Cancel</a>
  </div>
</div>
<!-- End of Sockets Form Dialog -->

<?php echo '<script'; ?>
>
function editsockets(){
  $.ajax({
    url: "manproducts.php?action=getsocket2edit&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
",
    type: "GET",
    dataType: "json",
    success: function(data) {
      for (var item in data){
        var tmpid = '#'+item+'_id';
        if ($(tmpid).attr('type') == 'checkbox'){
          if (data[item] == 1){
            $(tmpid).checkbox('check');
            sockets[item] = 1;
          } else {
            $(tmpid).checkbox('uncheck');
            sockets[item] = 0;
          }
         $(tmpid).checkbox({
           onChange: function(checked){
             var opts = $(this).checkbox('options');
             if (opts.checked){
               sockets[opts.value] = 1;
             } else {
               sockets[opts.value] = 0;
             }
           }//end of onChange
         });//checkbox onChange
       }//end of if
      }// end of for loop
      $('#socketformdlg').dialog('open');
    }
  });
}
function submitSocketForm(){
  var form = $('#socketform')[0];
  var cform = new FormData(form);
  sockets.forEach((item) => cform.append("sockets[]", item));
  for(var index in sockets) {
    cform.append(index, sockets[index]);
  }
  $.ajax({
    type: 'POST',
    data: cform,
    processData: false,
    contentType: false,
    enctype: 'multipart/form-data',
    url: 'manproducts.php?action=savesocket',
    success:function(data){
      $("#mainsocketlist").textbox('setValue',data);
    }
  });
  $('#socketformdlg').dialog('close');
}
function cancelSocketForm(){
  $('#socketformdlg').dialog('close');
}
<?php echo '</script'; ?>
>
<?php }
}
