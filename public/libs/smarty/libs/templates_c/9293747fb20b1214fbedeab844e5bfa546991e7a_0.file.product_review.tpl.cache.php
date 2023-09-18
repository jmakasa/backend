<?php
/* Smarty version 3.1.34-dev-7, created on 2023-06-14 14:28:21
  from '/akasa/www/marketing/templates/product_review.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6489ce85470cb5_88653198',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9293747fb20b1214fbedeab844e5bfa546991e7a' => 
    array (
      0 => '/akasa/www/marketing/templates/product_review.tpl',
      1 => 1686752895,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6489ce85470cb5_88653198 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '10761590236489ce8546f551_34895917';
?>
    <div title="Product Reviews" data-options="iconCls:'icon-hand-thumbs-up'">
    <div style="width:700px;height:800px;float:left;">
      <reviewsites-directive></reviewsites-directive>
    <div style="width:700px;height:300px;margin-top:5px;">
    <div style="width:160px;height:300px;float:left;">
    <div class="easyui-panel" id="rs_iconpanel" title="Preview Icon" style="width:160px;height:330px;float:left;">
    </div>
    </div>
    <div class="easyui-panel" id="rf_panel" title="Add Review to Product" style="width:530px;height:330px;float:left;">
<!-- Begin of Product Review Form -->

      <form id="reviewform" method="post">
      <input type="text" id="pr_id" name="id" hidden=true>
      <input type="text" id="pr_siteid" name="siteid" hidden=true>
      <input type="text" id="pr_partno" name="partno" hidden=true>
      <input type="text" id="pr_lang" name="lang" hidden=true>
      <div style="margin-bottom:5px;">
      <input class="easyui-textbox" name="seqno" style="width:510px;" data-options="label:'Seqno:',labelAlign:'right',labelWidth:'90px'">
      </div>
      <div style="margin-bottom:5px;">
      <input class="easyui-textbox" name="articlelink" style="width:510px;" data-options="label:'Article Link:',labelAlign:'right',labelWidth:'90px'">
      </div>
      <div style="margin-bottom:5px;">
      <input class="easyui-textbox" name="summary" style="width:510px;height:100px;" data-options="label:'Summary:',labelWidth:'85px',labelAlign:'right',multiline:'true'">
      </div>
      <input class="easyui-textbox" name="comment" style="width:510px;height:80px;" data-options="label:'Comment:',labelWidth:'85px',labelAlign:'right',multiline:'true'">
      </form>

  <div style="text-align:center;padding:5px 0">
    <a href="javascript:void(0)" id="rf_addbtn" class="easyui-linkbutton" onclick="submitReviewForm()" style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelReviewForm()" style="width:80px">Cancel</a>
  </div>
<!-- End of Product Review Form -->

    </div>
    </div>
    </div>

    <div style="width:1010px;height:800px;float:left;">
    <table id="reviewlist"
      class="easyui-datagrid"
      title="Products Reviews"
      data-options="singleSelect:'true',fitColumns:'true',pagination:'true',pageSize:'10',sortORder:'asc',sortName:'seqno', width:'1000',height:'835', url:'manreviews.php?action=listprodreviews&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
',toolbar:'#pr_toolbar'">
    <thead>
    <tr>
    <th field="id" width="40" sortable="true" hidden=true>ID</th>
    <th field="sitename" width="80" sortable="true">Site Name</th>
    <th field="siteurl" width="80" sortable="true" hidden=true>Site Link</th>
    <th field="sitelogo" width="80" sortable="true" hidden=true>Award Icon</th>
    <th field="seqno" width="80" sortable="true" >Seqno</th>
    <th field="articlelink" width="80" sortable="true">Article Link</th>
    <th field="summary" width="80" sortable="true">Summary</th>
    <th field="comment" width="80" sortable="true">Comment</th>
    </tr>
    </thead>
    </table>
    <div id='pr_toolbar'>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-pencil" plain="true" onclick="EditReview('1')" style="width:120px">Edit Review</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-trash" plain="true" onclick="DeleteReview()" style="width:140px">Delete Review</a>
    </div>
    </div>

    </div>

<?php echo '<script'; ?>
>
$(function(){
  // $('#reviewlist').datagrid({
  // view: cardview
  // });

  $('#rf_addbtn').linkbutton('disable');

  $('#sitenamekey').combobox({
    onSelect:function(record){
      var url = "manreviews.php?action=listsites&sitename="+record.name;
      $('#sitelist').datagrid({ url: url });
      $('#sitelist').datagrid('reload');
    }
  });
     
});

$(function(){
  $('#sitelist').datagrid({
    title:'Review Site Award Icon List',
    width:690,
    height:500,
    toolbar: '#rs_toolbar',
    singleSelect:true,
    pagination:true,
    pageSize: 10,
    pageList: [10,20,40],
    idField:'id',
    url:'manreviews.php?action=listsites',
    columns:[[
      {field:'id',title:'ID',width:40,hidden:true},
      {field:'sitename',title:'Name',width:200,sortable:true},
      {field:'siteurl',title:'Web Site',width:260,sortable:true},
      {field:'sitelogo',title:'icon name',width:210,sortable:true},
    ]],
    onSelect: function(index,row){
      $('#rs_iconpanel').panel('refresh','manreviews.php?action=geticon&id='+row.id);
      $('#reviewform').form('clear');
      $('#pr_id').val('-1');
      $('#pr_siteid').val(row.id);
      $('#pr_partno').val('<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
      $('#pr_lang').val('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
      $('#rf_panel').panel('setTitle','Add Product Review');
      $('#rf_addbtn').linkbutton({text:'Add'});
      $('#rf_addbtn').linkbutton('enable');
    },
  });
});
// var loadreviewsite = function(param,success,error){
//   var q = param.q || '';
//   if (q.length <= 2){return false}
//     $.ajax({
//     url: 'getreviewsite.php',
//     dataType: 'json',
//     data: {
//       q: q
//     },
//     success: function(data){
//       var items = $.map(data, function(item){
//       return {
//         id: item.id,
//         name: item.name
//         };
//       });
//       success(items);
//     },
//   error: function(){
//     error.apply(this, arguments);
//   }
//   });
// }
function searchsite(){
  var key = $("#sitenamekey").combobox('getValue');
  $("#partnokey").combobox('clear');
  url = "manreviews.php?action=listsites&sitename="+key;
  $('#sitelist').datagrid({
     url: url
  });
  $('#sitelist').datagrid('reload');
}
function refreshsite(){
  url = "manreviews.php?action=listsites";
  $('#sitelist').datagrid({
     url: url
  });
  $('#sitelist').datagrid('reload');
}
function EditReview(eflag){
  if (eflag == '1') {
    var selectedrow = $("#reviewlist").datagrid("getSelected");
    if (selectedrow == null) {
      alert("Please Select a row to Edit!");
    } else {
      $('#rf_panel').panel('setTitle','Edit Product Review');
      $('#rf_addbtn').linkbutton({text:'Save'});
      $.ajax({
        url: "manreviews.php?action=getreview2edit&id="+selectedrow.id,
        type: "GET",
        dataType: "json",
        success: function(data) {
          $('#reviewform').form('load', data);
          $('#rf_addbtn').linkbutton('enable');
//          $('#reviewformdlg').dialog('open');
        }
      });
    }
  } else {
    $('#reviewform').form('clear');
    $('#pr_id').val('-1');
    $('#pr_partno').val('<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
    $('#pr_lang').val('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
//    $('#reviewformdlg').dialog('open');
  }
}
function DeleteReview(){
    var selectedrow = $("#reviewlist").datagrid("getSelected");
    if (selectedrow == null) {
      alert("Please Select a row to Delete!");
    } else {
    $.messager.confirm('Confirm','Are you sure? 確認刪除?',function(r){
    if (r){
      $.ajax({
        url: "manreviews.php?action=deletereview&id="+selectedrow.id,
        type: "GET",
        dataType: "json",
        success: function(data) {
          $("#reviewlist").datagrid("reload");
        }
      }); //end of ajax
      } // end of if confirm
      });// end of confirm messager
    }
}
function editreviewicon(editmode){
  
  if (editmode == '-1'){
    $("#rif_id").val(editmode);
    $('#reviewiconformdlg').dialog('open');
  } else {
    var selectedrow = $("#sitelist").datagrid("getSelected");
    if (selectedrow == null) {
      alert("Please Select a row to Edit!");
    } else {
      $.ajax({
        url: "manreviews.php?action=geticon2edit&id="+selectedrow.id,
        type: "GET",
        dataType: "json",
        success: function(data) {
          $('#reviewiconform').form('load', data);
//          $('#rif_submitbutton').linkbutton({text:'Save'});
          $('#reviewiconformdlg').dialog('open');
        }
      });
    }
  }
}
function submitReviewIconForm(){
  $('#reviewiconform').form('submit',{
    url: 'manreviews.php?action=savereviewicon',
    success:function(data){
      $('#reviewiconformdlg').dialog('close');
      $("#sitelist").datagrid("reload");
    }
  });
}
function cancelReviewIconForm(){
  $('#reviewiconform').form('clear');
  $('#reviewiconformdlg').dialog('close');
}
function submitReviewForm(){
  $('#reviewform').form('submit',{
    url: 'manreviews.php?action=savereview',
    success:function(data){
//      $('#reviewformdlg').dialog('close');
      $('#reviewform').form('clear');
      $('#rf_addbtn').linkbutton('disable');
      $("#reviewlist").datagrid("reload");
    }
  });
}
function cancelReviewForm(){
  $('#reviewform').form('clear');
  $('#rf_addbtn').linkbutton('disable');
//  $('#reviewformdlg').dialog('close');
}
<?php echo '</script'; ?>
>
<?php }
}
