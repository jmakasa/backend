<?php
/* Smarty version 3.1.34-dev-7, created on 2023-02-02 10:27:31
  from '/akasa/www/marketing/templates/socketform_new.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63db90136dfe49_70541268',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0cb9a9c84528283295f0768dc3b8864750642a72' => 
    array (
      0 => '/akasa/www/marketing/templates/socketform_new.tpl',
      1 => 1669823959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63db90136dfe49_70541268 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '209919172063db90136dc988_42173674';
?>
<!-- Begin of Sockets Form Dialog -->
<div  class="easyui-dialog" id="newsocketformdlg"  data-options="resizable:true" style="width:830px;height:570px;padding:10px 20px" closed="true"  buttons="#dlg-buttons" title="Edit Cooler Sockets">
      <form id="newsocketform" method="post">
      <input type="text" name="partno" hidden=true value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
<fieldset>
<legend><b>Intel Sockets:</b></legend>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newSockets']->value['intel'], 'socket', false, NULL, 'intel', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['socket']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_intel']->value['index']++;
if (((isset($_smarty_tpl->tpl_vars['__smarty_foreach_intel']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_intel']->value['index'] : null)%4 == 0)) {?>
<p>
  <?php }?>
<input type="checkbox" class="easyui-checkbox" id="new_<?php echo $_smarty_tpl->tpl_vars['socket']->value['skey'];?>
_id" name="newsockets" label="<?php echo $_smarty_tpl->tpl_vars['socket']->value['display_name'];?>
" labelAlign="left" labelPosition="after" labelwidth="140" value="<?php echo $_smarty_tpl->tpl_vars['socket']->value['skey'];?>
">
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</fieldset>
<p>
<fieldset>
<legend><b>AMD Sockets:</b></legend>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newSockets']->value['amd'], 'socket', false, NULL, 'amd', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['socket']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_amd']->value['index']++;
if (((isset($_smarty_tpl->tpl_vars['__smarty_foreach_amd']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_amd']->value['index'] : null)%4 == 0)) {?>
<p>
  <?php }?>
<input type="checkbox" class="easyui-checkbox" id="new_<?php echo $_smarty_tpl->tpl_vars['socket']->value['skey'];?>
_id" name="newsockets" label="<?php echo $_smarty_tpl->tpl_vars['socket']->value['display_name'];?>
" labelAlign="left" labelPosition="after" labelwidth="140" value="<?php echo $_smarty_tpl->tpl_vars['socket']->value['skey'];?>
">
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</fieldset>
      </form>
  <div style="text-align:center;padding:5px 0">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitNewSocketForm()" style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelNewSocketForm()" style="width:80px">Cancel</a>
  </div>
</div>
<!-- End of Sockets Form Dialog -->

<?php echo '<script'; ?>
>
function editnewsockets(){
  $.ajax({
    url: "manproducts.php?action=getnewsocket2edit&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
",
    type: "GET",
    dataType: "json",
    success: function(data) {
      console.log(data);
      data.forEach(isSocketChecked);
      for (var item in data){
        console.log(item);
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
      $('#newsocketformdlg').dialog('open');
    }
  });
}

function isSocketChecked(item) {
  var tmpid = '#new_'+item.skey+'_id';
        if ($(tmpid).attr('type') == 'checkbox'){
console.log(tmpid);
            $(tmpid).checkbox('check');

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
}

function submitNewSocketForm(){
  var checkedBoxes = getCheckedBoxes('newsockets');
  console.log(checkedBoxes);
  var fd = new FormData;

  fd.append('partno', '<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
for (var i = 0; i < checkedBoxes.length; i++) {
  console.log(checkedBoxes[i]);
  fd.append('selectedSockets[]', checkedBoxes[i]);
}

console.log(fd);
  $.ajax({
    type: 'POST',
    data: fd,
    processData: false,
    contentType: false,
    enctype: 'multipart/form-data',
    url: 'manproducts.php?action=saveprodsocket',
    success:function(data){
      $("#mainsocketlist").textbox('setValue',data);
    }
  });
  $('#newsocketformdlg').dialog('close');
}
function cancelNewSocketForm(){
  $('#newsocketformdlg').dialog('close');
}

  // Pass the checkbox name to the function
  function getCheckedBoxes(chkboxName) {
    var checkboxes = document.getElementsByName(chkboxName);
    var checkboxesChecked = [];
    // loop over them all
    for (var i = 0; i < checkboxes.length; i++) {

      if (checkboxes[i].checked) {
        // // console.log(checkboxes[i].value);
        checkboxesChecked.push(checkboxes[i].value);
      }
    }
    // Return the array if it is non-empty, or null
    return checkboxesChecked;
  }
<?php echo '</script'; ?>
>


<?php }
}
