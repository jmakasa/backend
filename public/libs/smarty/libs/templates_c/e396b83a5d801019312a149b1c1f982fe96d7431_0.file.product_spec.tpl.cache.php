<?php
/* Smarty version 3.1.34-dev-7, created on 2023-06-29 14:34:35
  from '/akasa/www/marketing/templates/product_spec.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_649d967bc16fa9_64375112',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e396b83a5d801019312a149b1c1f982fe96d7431' => 
    array (
      0 => '/akasa/www/marketing/templates/product_spec.tpl',
      1 => 1688049269,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_649d967bc16fa9_64375112 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1407181774649d967bc14c81_90249411';
?>
<div title="Specification" data-options="iconCls:'icon-clipboard'">
  <div id="cc" class="easyui-layout" style="width:1500px;height:700px;">


    <div data-options="region:'west',title:'LHS Menu',split:false" id="tt" class="easyui-tabs"
      style="width:250px;height:650px;padding:5px">
      <div title="List" style="padding:20px;display:none;">
        <ul class="easyui-tree" id="LHS_menu"></ul>
      </div>
      <div title="Spec Group" data-options="closable:true" style="overflow:auto;padding:20px;display:none;">
        <div id="LHStoolbar" class="datagrid-toolbar">
          <a id="specAddGroup" href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="openAddGroup()"
            iconCls='icon-add'>Group</a>
          <a id="specAddGroup" href="javascript:void(0)" class="easyui-linkbutton" plain="true"
            onclick="openEditGroup()" iconCls='icon-pencil'>Group</a>
        </div>
        <ul class="easyui-tree" id="spec_group_list"></ul>

      </div>
    </div>

    <div data-options="region:'center'" style="padding:5px;background:#eee;">
      <div id="divSpecHtml">

        <div id="p_spechtml" title="Spec HTML" class="easyui-panel" data-options="tools:[{
					iconCls:'icon-edit',
					handler:function(){editspechtml()}
				}]" style="margin-left:5px;width:650px;height:650px;float:left">
        </div>
      </div>
      <div id="divContentList">
        <table class="easyui-datagrid" id="contentList"></table>
      </div>
      <div id="divSpecList">
        <table class="easyui-datagrid" id="specList"></table>
      </div>
    </div>
    <div id="specImageToolbar">
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-plus" plain="true"
        onclick="editimage('Specification','-1')">Add</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-pencil" plain="true"
        onclick="editimage('Specification','0')">Edit</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-trash" plain="true"
        onclick="delimage('Specification', '#specImageList')">Delete</a>
    </div>
    <div id="spectoolbar">
      <a id="btaddspec" href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-plus" plain="true"
        onclick="addspec()">Add Spec</a>
      <a id="btdelspec" href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-trash" plain="true"
        onclick="delspec()">Delete Spec</a>
      <a href="javascript:void(0)" id="bteditspechtml" class="easyui-linkbutton" iconCls="icon-pencil" plain="true"
        onclick="editspechtml()">Edit Special Spec</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" ng-click="submitNewSpecGroup()"  style="width:80px">ngSave</a>
    </div>
  </div>

</div>

<?php echo '<script'; ?>
>
  var selectedGroup = '';
  var speditmode = '0';
  // start document ready
  $(function () {
    $('#divContentList').hide();
    $('#divSpecHtml').hide();
    $('#divSpecList').show();
    $('#specList').datagrid({
      title: 'Product Specification',
      toolbar: '#spectoolbar',
      width: 1200,
      height: 650,
      singleSelect: true,
      pagination: true,
      pageSize: 20,
      pageList: [20, 40],
      idField: 'id',
      //list_group
      url: "manprodspec.php?action=list_group",
      //url: backendApi + "/spec/child/list",
      queryParams: {
        partno: '<?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
',
        group_id: 'all',
        lang: '<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
'
      },
      columns: [[
        { field: 'id', title: 'ID', width: 60, sortable: true, align: 'center' },
        { field: 'seqno', title: 'Seqno', width: 70, sortable: true, align: 'center', editor: 'textbox' },
        {
          field: 'group_id', title: 'Group', width: 200, sortable: true, editor: 'textbox',
          formatter: function (value, row) {
            // for (var i = 0; i <products.length; i ++) {
            // 	if (products [i] .productid == value) return products [i] .name;
            // }
            if (row.group_id == 0) {
              return 'All';
            } else {
              return row.group_name;
            }
          },
          editor: {
            type: 'combobox',
            options: {
              valueField: 'group_id',
              textField: 'group_name',
              method: "GET",
              url: "manprodspec.php?action=active_spec_group_list&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
              required: false
            }
          }
        },
        { field: 'specname', title: 'Name', width: 200, sortable: true, editor: 'textbox' },
        { field: 'specdesc', title: 'Content', width: 380, sortable: true, editor:{type:'textbox',options:{height:200,multiline:true}}},
        {
          field: 'action', title: 'Action', width: 70, align: 'center',
          formatter: function (value, row, index) {
            if (row.editing) {
              var s = '<a href="javascript:void(0)" onclick="spsaverow(this)"><img src="/easyui/themes/icons/ok.png"></a> ';
              var c = '<a href="javascript:void(0)" onclick="spcancelrow(this)"><img src="/easyui/themes/icons/cancel.png"></a>';
              return s + '&nbsp;' + c;
            } else {
              var e = '<a href="javascript:void(0)" onclick="speditrow(this)"><img src="/easyui/themes/icons/pencil.png"></a> ';
              //            var d = '<a href="javascript:void(0)" onclick="spdeleterow(this)">Delete</a>';
              return e;
            }
          }
        }
      ]],
      onBeforeEdit: function (idx, row) {
        if (!row.group_id) {
          row.group_id = 1;
          row.group_name = "General Information";
        }
        row.editing = true;
        $(this).datagrid('refreshRow', idx);
      },
      onAfterEdit: function (index, row) {
        row.editing = false;
        $('#LHS_menu').tree('reload');
        $(this).datagrid('refreshRow', index);
      },
      onCancelEdit: function (index, row) {
        row.editing = false;
        $(this).datagrid('refreshRow', index);
      },
      onEndEdit: function (index, row, changes) {
        $.post('manprodspec.php?action=save', { partno: partno, editmode: speditmode, lang: lang, items: row },
          function (r) {
            $('#LHS_menu').tree('reload');
            $("#specList").datagrid("reload");
          }
        );
        speditmode = '0';
      }
    });
    // call tree
    // tree
    $('#spec_group_list').tree({
      method: "GET",
      url: "manprodspec.php?action=spec_group_list&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      title: 'Spec Group List',
      formatter: function (node) {
        if (node.status == 1) {
          return node.group_name + "&nbsp;&nbsp;<a href='#' onclick='inactiveGroup(" + node.id + ")' title='Click to disable this group'><img src='/icons-main/icons/x.svg'></a>";
        } else {
          return "<s>" + node.group_name + "&nbsp;&nbsp;<a href='#' onclick='activeGroup(" + node.id + ")' title='Click to enable this group'><img src='/icons-main/icons/arrow-clockwise.svg'></a></s>";
        }

      },
      onClick: function (node) {
        selectedGroup = node;
        console.log(node);
      }
    });
    $('#LHS_menu').tree({
      method: "GET",
      url: "manprodspec.php?action=LHS_menu&partno=<?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      //url: backendApi + "/spec/lhs_tree/<?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
",
      formatter: function (node) {
        if (node.text == null) {
          return 'ALL';
        } else {
          return node.text;
        }
      },
      onClick: function (node) {
        switch (node.text) {
          case 'Content':
            $('#divContentList').show();
            $('#divSpecHtml').hide();
            $('#divSpecList').hide();
            var url = 'manimages.php?action=list&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
&imgtype=Specification&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
';
            $('#contentList').datagrid({
              title: 'Content/Package',
              toolbar: '#specImageToolbar',
              view: cardview_specImage,
              url: url,
              width: 1200,
              height: 650,
              singleSelect: true,
              pagination: true,
              pageSize: 20,
              pageList: [20, 40],
              idField: 'id',
              columns: [[
                { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
                { field: 'docname', title: 'File Name', width: 250, sortable: true },
                { field: 'seqno', title: 'Seqno', width: 150 },
                { field: 'caption', title: 'Caption', width: 150 },
                { field: 'comment', title: 'Comment', width: 150 },
              ]],
              onDblClickRow(index, row) {
                $("#viewImageSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Specification/' + row.docname);
                $('#dlgViewImage').dialog('open');
              },
              onLoadSuccess: function () {
              }
            });
            break;
          case 'Spec Html':
            $('#divContentList').hide();
            $('#divSpecHtml').show();
            $('#divSpecList').hide();
            break;
          default:
            if (node.id == null) {
              node.id = 'all';
            }
            console.log(node);
            $('#divContentList').hide();
            $('#divSpecHtml').hide();
            $('#divSpecList').show();
            $('#specList').datagrid({
              title: 'Product Specification - ' + node.text,
              url: "manprodspec.php?action=list_group",
              queryParams: {
                partno: '<?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
',
                group_id: node.id,
                lang: '<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
'
              }
            });
            break;


        }

      }
    });
    // END tree

    $('#specImageList').datagrid({
      title: 'Content/Package',
      toolbar: '#specImageToolbar',
  //    view: cardview_specImage,
      width: 200,
      height: 650,
      singleSelect: true,
      pagination: true,
      pageSize: 10,
      pageList: [10, 20, 40],
      idField: 'id',
      columns: [[
        { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
        { field: 'docname', title: 'File Name', width: 150, sortable: true },
        { field: 'seqno', title: 'Seqno', width: 150 },
        { field: 'caption', title: 'Caption', width: 150 },
        { field: 'comment', title: 'Comment', width: 150 },
      ]],
      onDblClickRow(index, row) {
        $("#viewImageSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Specification/' + row.docname);
        $('#dlgViewImage').dialog('open');
      }
    });

    var url = 'manimages.php?action=list&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
&imgtype=Specification&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
';
    $("#specImageList").datagrid({ url: url });

    $('#p_spechtml').panel({
      href: 'manprodspec.php?action=showspechtml&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });

  });// end document ready

  // function
  function speditrow(target) {
    $('#specList').datagrid('beginEdit', getRowIndex(target));
  }
  function spdeleterow(target) {
    $.messager.confirm('Confirm', 'Are you sure?', function (r) {
      if (r) {
        $('#specList').datagrid('deleteRow', getRowIndex(target));
      }
    });
  }
  function spsaverow(target) {
    $('#specList').datagrid('endEdit', getRowIndex(target));
  }
  function spcancelrow(target) {
    $('#specList').datagrid('cancelEdit', getRowIndex(target));
    $('#specList').datagrid("reload");
  }
  function addspec() {
    index = 0;
    speditmode = '1';
    $('#specList').datagrid('insertRow', {
      index: index,
      row: {
        crmid: '-1'
      }
    });
    $('#specList').datagrid('selectRow', index);
    $('#specList').datagrid('beginEdit', index);
  }
  function delspec() {
    var srow = $("#specList").datagrid("getSelected");
    if (srow == null) {
      alert("Please Select a Row to Delete! 請選一列!");
    } else {
      $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
        if (r) {
          $.ajax({
            url: "manprodspec.php?action=delete&id=" + srow.id,
            type: "GET",
            dataType: "json",
            success: function (data) {
              $('#specList').datagrid('reload');
            }
          }); //end of ajax
        } // end of if confirm
      }); // end of confirm messager
    }
  }



  ///spec/group/add
  function openAddGroup() {
    $('#dlgAddSpecGroup').dialog('open');
  }

  function SubmitSpecAddGroupForm() {
    $('#addSpecGroupForm').form('submit', {
      url: "manprodspec.php?action=add_new_group",
      dataType: "json",
      success: function (resp) {

        $('#dlgAddSpecGroup').dialog('close');
        // reload
        $('#LHS_menu').tree('reload');
        $('#spec_group_list').tree('reload');
      }
    });
  }

  function CancelSpecAddGroupForm() {
    $('#dlgAddSpecGroup').dialog('close');
  }
  function openEditGroup() {
    if (selectedGroup) {
      $('#editSpecGroupForm').form('load', selectedGroup);
      $('#editSpecGroupForm_group_name').textbox('setValue', selectedGroup.group_name);
      $('#editSpecGroupForm_seqno').textbox('setValue', selectedGroup.seqno);
      
      $('#dlgEditSpecGroup').dialog('open');
    } else {
      alert("Please Select a Spec Group 請選一列!");
    }
  }

  function SubmitSpecEditGroupForm() {
    console.log("SubmitSpecEditGroupForm");
    var newGroupName = $('#editSpecGroupForm_group_name').textbox('getValue');
    var newSeqno = $('#editSpecGroupForm_seqno').textbox('getValue');
    console.log(newGroupName);
    console.log(selectedGroup.group_name);
    if (newGroupName != selectedGroup.group_name || newSeqno != selectedGroup.seqno ) {
      fd = new FormData();
      fd.append('groupname', newGroupName);
      fd.append('seqno', newSeqno);
      fd.append('groupid', selectedGroup.id);
      fd.append('lang', '<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
      $.ajax({
        url: "manprodspec.php?action=update_group",
        enctype: 'multipart/form-data',
        type: 'post',
        data: fd,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
          console.log("DONE " + response);
          if (response) {
            $('#dlgEditSpecGroup').dialog('close');
            // reload
            $('#spec_group_list').tree('reload');
          } else {
            console.log(" Error occured. Please contact IT admin. ");
          }

        }
      });
    }
  }

  function CancelSpecEditGroupForm() {
    $('#dlgEditSpecGroup').dialog('close');
  }
  function inactiveGroup(id) {
    $.messager.confirm('Confirm', 'Are you sure? 確認移除?', function (r) {
      if (r) {
        $.ajax({
          url: "manprodspec.php?action=inactive_group&group_id=" + id + "&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
          type: "GET",
          dataType: "json",
          success: function (data) {
            $('#spec_group_list').tree('reload');
          }
        }); //end of ajax
      } // end of if confirm
    }); // end of confirm messager

  }
  function activeGroup(id) {
    $.messager.confirm('Confirm', 'Are you sure? 確認移除?', function (r) {
      if (r) {
        $.ajax({
          url: "manprodspec.php?action=active_group&group_id=" + id + "&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
          type: "GET",
          dataType: "json",
          success: function (data) {
            $('#spec_group_list').tree('reload');
          }
        }); //end of ajax
      } // end of if confirm
    }); // end of confirm messager

  }

  function editspechtml() {
    var url = "manprodspec.php?action=getspechtml&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
";
    $.ajax({
      url: url,
      type: "GET",
      dataType: "json",
      success: function (data) {
        $("#spechtml_id").summernote('reset');
        $("#spechtml_id").summernote('code', data.html_1);
      }
    });
    $('#spechtmlformdlg').dialog('open');
  }
  function SubmitSpechtmlForm() {
    $('#spechtmlform').form('submit', {
      url: 'manprodspec.php?action=savespechtml',
      success: function (data) {
        $('#spechtmlformdlg').dialog('close');
        $('#p_spechtml').panel('refresh');
      }
    });
  }
  function CancelSpechtmlForm() {
    $('#spechtmlformdlg').dialog('close');
  }
<?php echo '</script'; ?>
><?php }
}
