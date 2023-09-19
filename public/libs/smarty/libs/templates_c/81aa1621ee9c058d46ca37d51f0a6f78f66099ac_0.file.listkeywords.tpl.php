<?php
/* Smarty version 3.1.34-dev-7, created on 2023-09-08 16:55:19
  from '/akasa/www/marketing/templates/keywords/listkeywords.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64fb51f7069df9_86739069',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '81aa1621ee9c058d46ca37d51f0a6f78f66099ac' => 
    array (
      0 => '/akasa/www/marketing/templates/keywords/listkeywords.tpl',
      1 => 1694192117,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/navmenu.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_64fb51f7069df9_86739069 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid">
    <div class="row">
      <div class="nav">
        <div class="nav_left">
          <h5 class="float-start p-1 ms-2"><?php echo $_smarty_tpl->tpl_vars['webtitle']->value;?>
</h5>&nbsp;&nbsp;&nbsp;
          <a id="btexport" href="javascript:void(0)" class="btn btn-sm btn-primary float-end" onclick="exportFilterItem()"><i class="bi bi-file-arrow-down-fill"></i>&nbsp;Export Filter List</a>
          <a id="btexport" href="javascript:void(0)" class="btn btn-sm btn-orange float-end mx-1" onclick="viewFIlterTypeList()"><i class="bi bi-eye"></i>&nbsp;View Filter Type</a>
          <a id="btexport" href="javascript:void(0)" class="btn btn-sm btn-orange float-end mx-1" onclick="addKeywordType()"><i class="bi bi-pencil"></i>&nbsp;Add Filter Type</a>
        </div>
      </div>
      <div class="row">
        <div class="col-5">
          <div class="panel main_panel" style="width:100%;float:left">
            <div class="panel-header">
              <div class="panel-title" id="allProductsTitle">All Filters</div>
              <div class="panel-tool"></div>
            </div>
            <div class="panel-body">
              <div id='keywordlist_toolbar' class="toolbar_h2">
                <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1"
                  onclick="addKeyword()"><i class="bi bi-pencil"></i>&nbsp;Add Filter</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1"
                  onclick="editKeyword()">Edit Filter</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1"
                  onclick="delKeyword()">Delete Filter</a>
    
                <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1"
                  onclick="clearSelections('keywordlist')">Clear</a>
                <p>
                  <input id="tools_ksmode" name="type" type="text">
                  <input id="tools_keywordtype" name="type" type="text">
                </p>
    
              </div>
              <table id="keywordlist" style="width:auto;height:740px">
                <thead>
                  <tr>
                    <th data-options="field:'id'">Item ID</th>
                    <th data-options="field:'name'">Product</th>
                    <th data-options="field:'display_name_en'">List Price</th>
                    <th data-options="field:'display_name_cn'">List Price</th>
                    <th data-options="field:'type'">Unit Cost</th>
                    <th data-options="field:'status'">Status</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="col-5">
          <div class="panel main_panel" style="width:100%;float:left">
            <div class="panel-header">
              <div class="panel-title" id="allProductsTitle">Products</div>
              <div class="panel-tool"></div>
            </div>
            <div class="panel-body">
              <div id='productlist_toolbar' class="toolbar_h2">
    
                <label>Search productcode :</label>
                <input id="search_partno" name="partno" value="" type="text" class="textbox-text textbox-prompt"
                  autocomplete="off" tabindex="" placeholder="Search Product Code..."
                  style="margin: 0px 52px 0px 0px; padding-top: 2px; padding-bottom: 0px; height: 28px; line-height: 28px; width: 250px;">
    
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true"
                  onclick="clearSelections('productlist')">Clear Selection</a>
                <a href="#" class="easyui-linkbutton" id="edit_product_ps" iconCls="icon-add"
                  style="margin-right:3px;float:right;" onclick="addPatchKeyword()">Add Filter to Product</a>
                <p>
                  <input id="tools_psmode" name="type" type="text">
                </p>
    
              </div>
              <table id="productlist" style="width:auto;height:740px"></table>
            </div>
          </div>
        </div>
        <div class="col-2">
          <div class="easyui-panel main_panel" id="prod_key_panel" style="width:100%;float:left">
            <div class="panel-header">
              <div class="panel-title">Product's Filter</div>
              <div class="panel-tool"></div>
            </div>
            <div class="panel-body">
              <table id="prod_key_list" style="width:auto;height:353px"></table>
            </div>
          </div>
          <div class="easyui-panel main_panel" id="prod_in_key_panel" style="width:100%;float:left">
            <div class="panel-header">
              <div class="panel-title">Products in Filter</div>
              <div class="panel-tool"></div>
            </div>
            <div class="panel-body">
              <table id="prod_in_keyword" style="width:auto;height:353px"></table>
            </div>
          </div>
        </div>
      </div>
      
      
      
    </div>
  </div>

  <?php echo '<script'; ?>
>
    var productUrl = "manproducts.php?action=listproduct";
    function addChangeLog(){

    }

    function pageReloadDatagrid(lang){
      // add all list to be reloaded.
      //url: productUrl 
      $("#productlist").datagrid({
        url: productUrl,
        queryParams: {
        lang: getSessionLang(),
      },
      });
      $('#keywordlist').datagrid({
        url: 'mankeywordlist.php?action=list',
        queryParams: {
        lang: getSessionLang(),
      },
    });
    
    }

    const langkeys = Object.keys(aryLangs);

    const aryType = [];
   
    //aryType[1] = 'Socket';
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryKeywordTypes']->value, 'keywordtype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['keywordtype']->value) {
?>
    aryType[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
] = '<?php echo $_smarty_tpl->tpl_vars['keywordtype']->value;?>
';
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

      const aryTitle = [];
      aryTitle['keywordlist'] = "Filter";
      aryTitle['productlist'] = "Products";
      aryTitle['prod_key_list'] = "Product Filter";
      aryTitle['prod_in_keyword'] = "Product in ";

      function addKeywordType() {
        setKeyTypeForm('add');
        $('#dlgAddKeywordType').dialog('open');
      }

      function viewFIlterTypeList(){
// call data for keyword list

      $("#listFilterTypes").datagrid({
        url: backendApi + "/keyword_types/list",
        method: 'GET',
        pageSize: 50,
        showFooter: true,
        columns: [[
          {
            field: 'keyword_types', title: 'Type', width: '35%', sortable: true,
            formatter: function (value, row, index) {
              console.log(value);
             console.log(row);
            }
          },
          {
            field: 'keyword_name', title: 'Name', width: '55%', sortable: true,
          },  
          {field:'action',title:'Action',width:80,align:'center',
                formatter:function(value,row,index){
                    if (row.editing){
                        var s = '<a href="javascript:void(0)" onclick="saverow(this)">Save</a> ';
                        var c = '<a href="javascript:void(0)" onclick="cancelrow(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="javascript:void(0)" onclick="editKeywordTypeRow(this)">Edit</a> ';
                        var d = '<a href="javascript:void(0)" onclick="deleteKeywordType(this)">Delete</a>';
                        return e+d;
                    }
                }
            }
        ]],
        
      });

        $('#dlgFilterTypeList').dialog('open');
      }

      function closeFilterTypeList(){
        $('#dlgFilterTypeList').dialog('close');
      }

      function getRowIndex(target){
    var tr = $(target).closest('tr.datagrid-row');
    return parseInt(tr.attr('datagrid-row-index'));
}

      function deleteKeywordType(target){
        console.log(target);
        $.messager.confirm('Confirm','Are you sure?',function(r){
            if (r){
                $('#listFilterTypes').datagrid('deleteRow', getRowIndex(target));
            }
        });
    }
    function editKeywordTypeRow(target){
      console.log(target);
       $('#listFilterTypes').datagrid('beginEdit', getRowIndex(target));
    }


      function addKeyword() {
        setForm('add');
        $('#dlgAddKeyword').dialog('open');
      }

      function addPatchKeyword() {
        var selectedKeys = '';
        var kldg = $('#keywordlist');
        $.map(kldg.datagrid('getChecked'), function (row) {
          if (selectedKeys) {
            selectedKeys = selectedKeys.concat(",", row.skey);
          } else {
            selectedKeys = row.skey;
          }
        });
        //console.log(selectedKeys);

        var selectedPartno = '';
        var proddg = $('#productlist');
        $.map(proddg.datagrid('getChecked'), function (row) {
          console.log(row);
          if (selectedPartno) {
            selectedPartno = selectedPartno.concat(",", row.partno);
          } else {
            selectedPartno = row.partno;
          }
        });
        // console.log(selectedPartno);

        if (selectedKeys == "" && selectedPartno == "") {
          alert("Please Select at least one FILTER and PRODUCT.");
        } else if (selectedKeys == "" && selectedPartno != "") {
          alert("Please Select at least one FILTER .");
        } else if (selectedKeys != "" && selectedPartno == "") {
          alert("Please Select at least one PRODUCT.");
        }

        // call ajax call action : saveprodkeywords
        fd = new FormData();
        fd.append('selectedKeys', selectedKeys);
        fd.append('partnos', selectedPartno);
        $.ajax({
          url: 'mankeywordlist.php?action=savepatchkey2prod',
          enctype: 'multipart/form-data',
          type: 'post',
          data: fd,
          async: true,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (response) {
            if (response.result) {
              clearSelections('keywordlist');
              clearSelections('productlist');
              $("#prod_key_list").datagrid("reload");
              $("#prod_in_keyword").datagrid("reload");
            } else {
              alert("Failed to add Filter.");
            }

          }
        });
        fd = new FormData();
      }

      function editKeyword() {
        var selectedrows = $("#keywordlist").datagrid("getSelections");

        if (selectedrows.length == 0) {
          alert("Please Select a Filter record to Edit");
        } else if (selectedrows.length > 1) {
          alert("Only allow one selection.");
        } else {
          var srow = selectedrows[0];
          $.ajax({
            url: "mankeywordlist.php?action=getKeyword&skey=" + srow.skey,
            type: "GET",
            dataType: "json",
            success: function (resp) {
              if (resp.result) {
                // console.log(resp.data);
                setForm('edit');
                $('#frmKeywords').form('load', resp.data);
                $('#dlgAddKeyword').dialog('open');
              } else {
                console.log(" No Record ");
              }

            }
          });
        }
      }

      function clearSelections(listId) {
        $("#" + listId).datagrid("clearSelections");
        $("#" + listId).datagrid("clearChecked");

      }
      function delKeyword() {
        var selectedrows = $("#keywordlist").datagrid("getSelections"); 
        if (selectedrows.length == 0) {
          alert("Please select one of Filter to DELETE.");
        } else if (selectedrows.length > 1) {
          alert("Only allow one selection.");
        } else {
          $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
            if (r) {
              var srow = selectedrows[0];
              $('#frmDelKeywordId').val(srow.id);
             
              $('#delKeyword').form('submit', {
                url: 'mankeywordlist.php?action=delete&lang='+getSessionLang(),
                success: function (resp) {
                  $("#keywordlist").datagrid("reload");
                } // end of if confirm
              }); // end of confirm messager
            }
          })
        }
      }

      function submitKeywordForm() {
        // console.log(" submit ");
        $('#frmKeywords').form('submit', {
          url: 'mankeywordlist.php?action=save',
          success: function (data) {
            $('#dlgAddKeyword').dialog('close');
            $("#keywordlist").datagrid("reload");
          }
        });
      }
      function cancelKeywordForm() {
        $('#dlgAddKeyword').dialog('close');
        $('#frmKeywords').form('clear');
      }

      function submitKeywordTypeForm() {
        // console.log(" submit ");
        $('#frmKeywordsType').form('submit', {
          url: 'mankeywordlist.php?action=savetype',
          success: function (data) {
            $('#dlgAddKeywordType').dialog('close');
            //$("#keywordlist").datagrid("reload");
          }
        });
      }
      function cancelKeywordTypeForm() {
        $('#dlgAddKeywordType').dialog('close');
        $('#frmKeywordsType').form('clear');
      }

      function setForm(action) {
        $('#frmKeywords').form('clear');
        $("#frmKeywords_editmode").val(action);
        $('#frmKeywords_status').combobox({
          width: 640,
          data: [
            { text: 'Active', id: '1', "selected": true },
            { text: 'Inactive', id: '0' },
          ],
          valueField: 'id', textField: 'text',
          label: 'Status :', labelWidth: '200px', labelAlign: 'right'
        });
        $('#frmKeywords_type').combobox({
          width: 640,
          data: [
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryKeywordTypes']->value, 'keywordtype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['keywordtype']->value) {
?>
        { text: '<?php echo $_smarty_tpl->tpl_vars['keywordtype']->value;?>
', id: '<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
' },
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        ],
          valueField: 'id', textField: 'text',
          label: 'Filter Type :', labelWidth: '200px', labelAlign: 'right'
      });
    }

    function setKeyTypeForm(action){
      $('#frmKeywordsType').form('clear');
        $("#frmKeywordsType_editmode").val(action);
        $('#frmKeywordsType_status').combobox({
          width: 640,
          data: [
            { text: 'Active', id: '1', "selected": true },
            { text: 'Inactive', id: '0' },
          ],
          valueField: 'id', textField: 'text',
          label: 'Status :', labelWidth: '200px', labelAlign: 'right'
        });
        $('#frmKeywordsType_type').combobox({
          width: 640,
          url: 'mankeywordlist.php?action=getFilterType',
          valueField: 'id', textField: 'text',
          label: 'Parent Filter Type :', labelWidth: '200px', labelAlign: 'right'
      });
    }


    function exportFilterItem() {
      $.ajax({
        url: "exportfilteritem.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
          if (data) {
            alert(" Filter Item list is exported. ");
          }
        }
      });
    }
    function removeProdKey(dipslayname, keyword, partno) {
      $.messager.confirm('Confirm', 'Are you sure to remove "' + dipslayname + '"? ', function (r) {
        if (r) {
          // call ajax call action : saveprodkeywords
          fd = new FormData();
          fd.append('skey', keyword);
          fd.append('partno', partno);
          $.ajax({
            url: 'mankeywordlist.php?action=removeprodkey',
            enctype: 'multipart/form-data',
            type: 'post',
            data: fd,
            async: true,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (resp) {
              if (resp.result) {
                // console.log(resp);
                $("#prod_key_list").datagrid("reload");
              } else {
                alert('Failed to remove key.');
              }
            }
          });
          fd = new FormData();
        }
      }, 'warning'); // end of confirm messager
    };

    function loadProdHasKeywords(partno) {

      $('#prod_key_list').datagrid({
        url: 'mankeywordlist.php?action=getkeywordbyprod&partno=' + partno,
        view: scrollview,
        method: 'GET',
        pageSize: 50,
        showFooter: true,
        columns: [[
          {
            field: 'type', title: 'Type', width: '35%', sortable: true,
            formatter: function (value, row, index) {

              return aryType[row.type];
            }
          },
          {
            field: 'display_name_en', title: 'Name', width: '55%', sortable: true,
          },
          {
            field: 'action', title: 'Action', width: '10%', align: 'center',
            formatter: function (value, row, index) {
              // console.log(row);
              return '<a href="javascript:void(0)" onclick="removeProdKey(\'' + row.display_name_en + '\',\'' + row.skey + '\',\'' + row.partno + '\')"><i class="bi bi-x-square"></i></a>';
            }
          }
        ]],
        onLoadSuccess: function (data) {
          if (data.total) {
            $("#prod_key_panel").panel('setTitle', aryTitle['prod_key_list'] + " [" + partno + "]" + " -Tot: " + data.total);
          } else {
            $("#prod_key_panel").panel('setTitle', aryTitle['prod_key_list'] + " [" + partno + "]" + " -Tot: 0");
          }

        }
      });
    }

    $(document).ready(function () {
      //setSessionLang('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
      setSessionRows('50');
      setSessionPageNo('1');

      $('#keywordlist').datagrid({
        url: 'mankeywordlist.php?action=list',
        // view: cardview_Keyword,
        toolbar: '#keywordlist_toolbar',
    //    method: 'GET',
        queryParams: {
        lang: getSessionLang(),
      },
        singleSelect: true,
        selectOnCheck: true,
        pageSize: 25,
        pageList: [25, 50, 100],
        idField: 'id',
        showHeader: true,
        view: scrollview,
        columns: [[
          { field: 'keychx', checkbox: true },
          { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center', hidden: false },
          { field: 'skey', title: 'Key', width: '20%', sortable: true, hidden: false },
          { field: 'display_name_en', title: 'Display Name', width: '20%', sortable: false, hidden: false },
          // { field: 'display_name_cn', title: 'Display Name (CN)', width: 145, sortable: false, hidden: false },
          { field: 'type', title: 'Type', width: '20%', sortable: true, hidden: false ,
          formatter: function (value, row, index) {

return aryType[row.type];
}
        },
          { field: 'seqno', title: 'seqno', width: '10%', sortable: true, align: 'center', hidden: false },
          {
            field: 'status', title: 'Status', width: '5%', sortable: true, align: 'center',
            formatter: function (value, row, index) {
              // console.log('keywordlist');
              // console.log(row);
              if (row.status == 1) {
                return '<i class="bi bi-check-circle-fill icon-green"></i>';
              } else {
                return '<i class="bi bi-x-circle  icon-grey"></i>';
              }
            },
          },
          { field: 'tot', title: 'Tot. Prod', width: 60, sortable: true, align: 'center', hidden: false },
        ]],
        onClickRow: function (index, row) {
          // show keyword
          // url getkeywordbyprod
          //  var title = aryTitle['prod_in_keyword'] + " ("+row.display_name_en+")";

          $('#prod_in_keyword').datagrid({
            url: 'mankeywordlist.php?action=getprodinkey&skey=' + row.skey,
            method: 'GET',
            pageSize: 25,
            view: scrollview,
            columns: [[

              {
                field: 'partno', title: 'Productcode', width: '80%', sortable: true,
                formatter: function (value, row, index) {
                  // console.log(row);
                  return "<span title='" + pstatusTitle[row.pstatus] + "' style='" + pstatusStyle[row.pstatus] + "; padding:3px 5px;'>" + row.partno +
                    "</span>";
                }
              },
              {
                field: 'active', title: 'Status', width: '20%', sortable: true, align: 'center',
                formatter: function (value, row, index) {
                  if (row.active == 1) {
                    return '<i class="bi bi-check-circle-fill icon-green"></i>';
                  } else {
                    return '<i class="bi bi-x-circle icon-grey"></i>';
                  }
                },
              }
            ]],
            onLoadSuccess: function (data) {
              $("#prod_in_key_panel").panel('setTitle', aryTitle['prod_in_keyword'] + " [" + row.display_name + "] -Tot:" + data.total);
            }
          });
        },
      });
      // define keyword type
      $('#tools_keywordtype').combobox({
        width: 265,
        // data: [
        //   { text: 'ALL', id: 'all' },
        //   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryKeywordTypes']->value, 'keywordtype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['keywordtype']->value) {
?>
        // { text: '<?php echo $_smarty_tpl->tpl_vars['keywordtype']->value;?>
', id: '<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
' },
        // <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        // ],
        url: 'mankeywordlist.php?action=getFilterType',
        valueField: 'id', textField: 'text',
        label: 'Type :', labelWidth: '65px', labelAlign: 'left',
        onChange: function (value) {
          $('#keywordlist').datagrid('load', {
            type: value,
            lang : getSessionLang(),
          });
        },
      });
    $('#tools_keywordtype').combobox('setValue', 'all');
    $('#tools_ksmode').combobox({
      width: 250,
      data: [
        { text: 'Single', id: 0 },
        { text: 'Multiple', id: 1 },

      ],
      valueField: 'id', textField: 'text',
      label: 'Selection Mode:', labelWidth: '125px', labelAlign: 'left',
      onChange: function (value) {
        $('#keywordlist').datagrid({ singleSelect: (value == 0) });
      }
    });
    $('#tools_psmode').combobox({
      width: 250,
      data: [
        { text: 'Single', id: 0 },
        { text: 'Multiple', id: 1 },

      ],
      valueField: 'id', textField: 'text',
      label: 'Selection Mode:', labelWidth: '125px', labelAlign: 'left',
      onChange: function (value) {
        $('#productlist').datagrid({ singleSelect: (value == 0) });
      }
    });

    // intial the #boxes_grid view

    $('#productlist').datagrid({
      toolbar: '#productlist_toolbar',
      url: productUrl,
      view: scrollview,
      pageSize: 25,
      singleSelect: true,
      selectOnCheck: true,
      multiSort: true,
      showFooter: true,
      queryParams: {
        lang: getSessionLang(),
      },
      columns: [[

        { field: 'prodchx', checkbox: true },
        { field: 'id', title: 'ID', width: '10%', sortable: true },
        {
          field: 'partno', title: 'Productcode', width: '20%', sortable: true,
          formatter: function (value, row, index) {
            // console.log(row);
            return "<span title='" + pstatusTitle[row.pstatus] + "' style='" + pstatusStyle[row.pstatus] + "; padding:3px 5px;'>" + row.partno +
              "</span>";
          }
        },
        {
          field: 'title', title: 'Title', width: '55%', sortable: true,
          formatter: function (value, row, index) {
            return "<span title='" + row.longdesc + "' >" + row.title +
              "</span>";
          }
        },
        {
          field: 'active', title: 'Status', width: '5%', sortable: true, align: 'center',
          formatter: function (value, row, index) {
            if (row.active == 1) {
                return '<i class="bi bi-check-circle-fill icon-green"></i>';
              } else {
                return '<i class="bi bi-x-circle icon-grey"></i>';
              }
          },
        },
        {
          field: 'keyword_cnt', title: 'Tot. Filter', width: '5%', sortable: true, align: 'center',
          formatter: function (value, row, index) {
            // console.log(value, row, index);
            if (row.keyword_cnt) {
              return row.keyword_cnt;
            } else {
              return 0;
            }
          },
        },

      ]],
      onLoadSuccess: function (data) {
        // console.log(' productlist onLoadSuccess');
        // console.log(data);
        // check if only one result 
        if (data.total == 1) {
          var prod = data.rows[0];

          loadProdHasKeywords(prod.partno);
          $(this).datagrid('selectRow', 0);
        }
      },
      onClickRow: function (index, row) {
        //console.log(row);
        // show keyword
        // url getkeywordbyprod
        loadProdHasKeywords(row.partno);
      },
      onDblClickRow: function (rowIndex, row) {
        console.log(row);
        let lang = $('#main_lang').combobox('getValue');
        var url = "manproducts.php?action=view&lang=" + getSessionLang() + "&partno=" + row.partno;
        OpenInNewTab(url);
      },
      //   onLoadSuccess: function (data) {
      //     console.log(" boxes onLoadSuccess");
      //     console.log(data);
      //     setNumberOfBoxestoolbar(data.total_boxes, data.total_products);
      //     $(this).datagrid('enableDnd');
      //   }

    });
    // // END the #boxes_grid view

    $('input#search_partno').keyup(function () {
      doSearch();
    });
    function doSearch() {
      $('#productlist').datagrid('load', {
        partno: $('#search_partno').val()
      });
    }


    // $("#main_lang").combobox({
    //   editable: false,
    //   onClick: function (record) {
    //     setSessionLang(record.value);
    //     getListProduct();
    //     //    $('#boxes').datalist("reload");
    //     reloadBoxes(); // function to reload #boxes
    //     reloadBoxesGrid();
    //     setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
    //   }
    // });
      });
  <?php echo '</script'; ?>
>
  <form id="delKeyword" enctype="multipart/form-data" method="post">
    <input type="text" id="frmDelKeywordId" name="id" value="" hidden=true>
  </form>

  <!-- Begin of add keyword Form Dialog JM-->
  <div class="easyui-dialog" id="dlgAddKeyword" data-options="resizable:true"
    style="width:850px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Add Filter">
    <form id="frmKeywords" enctype="multipart/form-data" method="post">
      <input type="text" id="frmKeywords_editmode" name="editmode" value="" hidden=true>
      <input type="text" id="id" name="id" value="" hidden=true>
      <p>
        <b>
          <input class="easyui-textbox" name="skey" style="width:640px;"
            data-options="label:'Key:',labelWidth:'200px',labelAlign:'right'">
        </b>
      </p>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arylangs']->value, 'ln');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ln']->value) {
?>
      <p>
        <b>
          <input class="easyui-textbox" name="display_name_<?php echo $_smarty_tpl->tpl_vars['ln']->value;?>
" style="width:640px;"
            data-options="label:'Display name (<?php echo $_smarty_tpl->tpl_vars['ln']->value;?>
):',labelWidth:'200px',labelAlign:'right'">
        </b>
      </p>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

      <p><b><input id="frmKeywords_type" name="type" type="text"></b></p>
      <p>
        <b>
          <input class="easyui-textbox" name="seqno" style="width:640px;"
            data-options="label:'Seqno:',labelWidth:'200px',labelAlign:'right'">
        </b>
      </p>
      <p><b><input id="frmKeywords_status" name="status" type="text"></b></p>
    </form>

    <div style="text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitKeywordForm()" style="width:80px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelKeywordForm()" style="width:80px">Cancel</a>
    </div>
  </div>
  <!-- End of add keyword Form Dialog -->

  <!-- Begin of add KEYWORD TYPE Form Dialog JM parent_id, kt_key, keyword_name, json, status -->
  <div class="easyui-dialog" id="dlgAddKeywordType" data-options="resizable:true"
  style="width:850px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Add Filter Type">
  <form id="frmKeywordsType" enctype="multipart/form-data" method="post">
    <input type="text" id="frmKeywordsType_editmode" name="editmode" value="" hidden=true>
    <input type="text" id="id" name="id" value="" hidden=true>
    <p><b><input id="frmKeywordsType_type" name="parent_id" type="text"></b></p>
    <p>
      <b>
        <input class="easyui-textbox" name="kt_key" style="width:640px;"
          data-options="label:'KEY ID (digit no):',labelWidth:'200px',labelAlign:'right'">
      </b>
    </p>
    <!-- <p>
      <b>
        <input class="easyui-textbox" name="keyword_types" style="width:640px;"
          data-options="label:'Filter Types (backend):',labelWidth:'200px',labelAlign:'right'">
      </b>
    </p> -->
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arylangs']->value, 'ln');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ln']->value) {
?>
    <p>
      <b>
        <input class="easyui-textbox" name="display_name_<?php echo $_smarty_tpl->tpl_vars['ln']->value;?>
" style="width:640px;"
          data-options="label:'Display Name on Webpage (<?php echo $_smarty_tpl->tpl_vars['ln']->value;?>
):',labelWidth:'200px',labelAlign:'right'">
      </b>
    </p>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <p><b><input id="frmKeywordsType_status" name="status" type="text"></b></p>
  </form>

  <div style="text-align:center;padding:5px 0">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitKeywordTypeForm()" style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelKeywordTypeForm()" style="width:80px">Cancel</a>
  </div>
</div>
<!-- End of add KEYWORD TYPE Form Dialog -->
    <!-- Begin List of filter type Dialog JM-->
    <div class="easyui-dialog" id="dlgFilterTypeList" data-options="resizable:true"
    style="width:1000px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="List of Filter types">

    <table id="listFilterTypes" style="width:auto;height:353px"></table>

    <div style="text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="closeFilterTypeList()"
        style="width:80px">Close</a>
    </div>
  </div>
  <!-- End of List of filter type Dialog -->
</body>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
