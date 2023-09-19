<?php
/* Smarty version 3.1.34-dev-7, created on 2023-03-17 17:43:51
  from '/akasa/www/marketing/templates/navmenu/listnavmenu_2022.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6414a6d77a8b85_09300155',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7ea9bc6e71cca60f9e49ccc99389969ea4caf53' => 
    array (
      0 => '/akasa/www/marketing/templates/navmenu/listnavmenu_2022.tpl',
      1 => 1679075029,
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
function content_6414a6d77a8b85_09300155 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

  <style>
    .note-editor{
      margin-left:150px;
    }
  </style>
  <div class="container-fluid">
    <div class="row p-2">
      <div class="col">
        <div title="Related Products" data-options="iconCls:'icon-clipboard'" id="tabsRelatedRroducts">
          <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="newMenu()"><i
              class="bi bi-plus-circle"></i>&nbsp;Add Menu</a>
          <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="exportBanner()"><i
              class="bi bi-file-arrow-down"></i>&nbsp;Export Banner to Akasa202206</a>
          <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="exportMenu()"><i
              class="bi bi-file-arrow-down"></i>&nbsp;Export Menu to Akasa202206</a>
          <a href="javascript:void(0)" class="btn btn-sm btn-primary m-1" onclick="exportMarketingMenu()"><i
              class="bi bi-file-arrow-down"></i>&nbsp;Export Menu to Backend [Marketing]</a>
          <div id="cc" class="easyui-layout" style="width:1700px;">
            <table>
              <tr>
                <td valign="top">
                  <div id="p" class="easyui-panel" title="Menucat"
                    style="width:350px;height:750px;padding:10px;float:left;display:inline">
                    <ul class=" " id="navTree"></ul>
                  </div>
                </td>
                <td valign="top">
                  <div id="formPanel" class="easyui-panel" title="Nav Menu Detail"
                    style="width:800px;height:750px;padding:10px;float:left;display:inline">
                    <form id="frmNavmenu" enctype="multipart/form-data" method="post">
                      <input name="action" id="frmNavmenuAction" type="hidden" value="new">
                      <input name="org_id" id="frmNavmenuOrgId" type="hidden" value="">
                      <p id="selectedCategory" style="padding-left:150px;font-weight: bold;color:blue"></p>
                      <p>
                        <b>
                          <select id="parent_cc" name="parent_id" class="easyui-combotree" style="width:640px;">
                          </select>
                        </b>
                      </p>
                      <p>
                        <b>
                          <input class="easyui-textbox" id="menuid" name="id" style="width:640px;"
                            data-options="label:'ID:',labelWidth:'150px',labelAlign:'right',readonly:true">
                        </b>
                      </p>
                      <p>
                        <b>
                          <input class="easyui-textbox" name="submenu" style="width:640px;"
                            data-options="label:'Sub Menu:',labelWidth:'150px',labelAlign:'right'">
                        </b>
                      </p>
                      <p>
                        <b>
                          <input class="easyui-textbox" name="display_name" style="width:640px;"
                            data-options="label:'Display Name:',labelWidth:'150px',labelAlign:'right'">
                        </b>
                      </p>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryLangs']->value, 'aLang');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['aLang']->key => $_smarty_tpl->tpl_vars['aLang']->value) {
$__foreach_aLang_0_saved = $_smarty_tpl->tpl_vars['aLang'];
?>
                    <p>
                      <b>
                        <input class="easyui-textbox" name="display_name_<?php echo $_smarty_tpl->tpl_vars['aLang']->key;?>
" style="width:640px;"
                          data-options="label:'Display Name(<?php echo $_smarty_tpl->tpl_vars['aLang']->key;?>
):',labelWidth:'150px',labelAlign:'right'">
                      </b>
                    </p>
                    <?php
$_smarty_tpl->tpl_vars['aLang'] = $__foreach_aLang_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>


                      <div style="margin-bottom:10px">
                        <input class="easyui-checkbox" name="has_child" value="1" id="frmNavmenu_has_child"
                          data-options="label:'has Child?:',labelWidth:'150px',labelAlign:'right'">
                      </div>
                      <p>
                        <input class="easyui-textbox" name="seqno" style="width:640px;"
                          data-options="label:'Seqno:',labelAlign:'right',labelWidth:'150px'">
                      </p>
                      <p>
                        <b>
                          <input class="easyui-textbox" id="status" name="status" style="width:640px;"
                            data-options="label:'Status:',labelWidth:'150px',labelAlign:'right'">
                        </b>
                      </p>
                      <hr>
                      <p>
                        <b>
                          <input class="easyui-textbox" name="title" style="width:640px;"
                            data-options="label:'Title:',labelWidth:'150px',labelAlign:'right'">
                        </b>
                      </p>
                      <p>
                        <label class="textbox-label textbox-label-before" for="_easyui_textbox_input1"
                          style="text-align: right; width: 146px; height: 24px; line-height: 24px; vertical-align: top;"><b>Short
                            Desc:</b></label>
                        <textarea class="summernote" name="desc" id="pr_shortdesc_id" rows="10" cols="64"></textarea>
                      </p>
                      <p>
                        <input class="easyui-textbox" name="css_style" style="width:640px;"
                          data-options="label:'Css Style:',labelAlign:'right',labelWidth:'150px'">
                      </p>
                      <div id="product_review_file"><b>
                          <input class="easyui-filebox" name="imagefile" style="width:640px;"
                            data-options="prompt:'Choose a file...',label:'Image File',labelWidth:'150px',labelAlign:'right'">
                        </b>
                        <p>
                      </div>
                      <div style="margin-bottom:10px">
                        <b>
                          <input class="easyui-checkbox" name="is_display_image" value="1" id="frmNavmenu_display_image"
                            data-options="label:'Display image?:',labelWidth:'150px',labelAlign:'right'">
                        </b>
                      </div>
                      <p>

                        <img src="" id="productReviewImageSrc" style="display: hidden; margin: auto;width:700px">
                    </form>

                    <div style="text-align:center;padding:5px 0">
                      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitNavmenuForm()"
                        style="width:80px">Save</a>
                      <!--a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelProductReviewsForm()"
                  style="width:80px">Cancel</a-->
                    </div>
                  </div>
                </td>
                <td valign="top">
                  <div id="p" class="easyui-panel" title="Filter Type"
                    style="width:350px;height:750px;padding:10px;float:left;display:inline">
                    <table class="table" id="filterType"></table>
                    <div id='filterType_toolbar' class="toolbar_h2">
                      <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="updateFilterType()"><i
                          class="bi bi-pencil"></i>&nbsp;Update Filter Type</a>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php echo '<script'; ?>
>
    // URL API LINK
    var listtable = '2020_prodlist';
    $(document).ready(function () {
console.log(aryLangs);

      setSessionRows('50');
      setSessionPageNo('1');
      // switchBoxView('grid');
      //console.log(getSessionLang());
      setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
      $('#navTree').tree({
        //navmenuOpenListUrl
        url: navmenuListUrl,
        method: "GET",
        formatter: function (node) {
          if (node.status == 1) {
            var s = node.submenu;
            if (node.children && node.children.length > 0) {
              s += '&nbsp;<i class="icon-check2">&nbsp;&nbsp;&nbsp;&nbsp;</i><span style=\'color:blue\'>(' + node.children.length + ')</span>';
            } else {
              s += '&nbsp;<i class="icon-check2">&nbsp;&nbsp;&nbsp;&nbsp;</i>';
            }
            return s;
          } else {
            var s = node.submenu;
            s += '&nbsp;<i class="icon-x-circle">&nbsp;&nbsp;&nbsp;&nbsp;</i>';
            return s;
          }
        },
        onClick: function (data) {
          // call api to get nav details
          
          $('#frmNavmenu').form('load', data);
          setValue(data.parent_id, data.parent);
          //check docname
          if (data.docname) {
            $("#productReviewImageSrc").attr("src", '../akasa2206/' + data.docname);
          }
          if (data.has_child) {
            $('#frmNavmenu_has_child').checkbox({ checked: true });
          }
          if (data.is_display_image) {
            $('#frmNavmenu_display_image').checkbox({ checked: true });
          }
          // set value to textarea
          console.log(data.desc);
          $("#pr_shortdesc_id").summernote('code', data.desc);
          $("#menuid").textbox({readonly:true});
          $("#frmNavmenuAction").val("update");
          $("#frmNavmenuOrgId").val(data.id);
          // get filter 
          $('#filterType').datagrid({
            url: getFilterByMenucatUrl + "&menucat=" + data.id,
            onLoadSuccess: function (data) {
              if (data) {
                for (i = 0; i < data.rows.length; ++i) {
                  if (data.rows[i]['selected'] == 1) $(this).datagrid('checkRow', i);
                }
              }
            }
          });
        },
        onBeforeLoad: function (node, param) {
          if (node != null && node.children.length === 0) {
            return false;
          }
        }
      });
      $('#pr_shortdesc_id').summernote({
              tabsize: 2,
              width: 490,
              height: 100,
              toolbar: [
                // ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                // ['para', ['ul', 'ol', 'paragraph']],
                // ['table', ['table']],
                // ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
              ]
            });
      //getkeywordTypeUrl
      $("#filterType").datagrid({
        singleSelect: false,
        pagination: false,
        height: 700,
        url: getkeywordTypeUrl,
        toolbar: '#filterType_toolbar',
        columns: [[
          { field: 'keychx', checkbox: true },
          { field: 'id', title: 'ID', width: '10%', sortable: true, align: 'center' },
          { field: 'ktype', title: 'Filter Type', width: '80%', sortable: true, align: 'center' },
        ]],
      });


      $('#status').combobox({
        valueField: 'value',
        textField: 'label',
        data: aryStatus,
        label: 'Status:',
        labelWidth: '150px',
        labelAlign: 'right',
      });
      // parent navmenu dropdown menu
      //$('#cc').combotree('setValue', '122');
      //url:navmenuOpenListUrl,required:true,method:'GET', valueField: 'id', textField: 'submenu',state:'open',dataType: 'json'
      $('#parent_cc').combotree({
        url: navmenuOpenListUrl,
        method: 'GET',
        label: 'Parent Nav Menu:',
        labelWidth: '150px',
        labelAlign: 'right',
        formatter: function (node) {
          return node.submenu;
        },
        onSelect: function (node) {
          setValue(node.id, node.submenu);
        }
      });
      $('#formPanel').panel({
        tools: [{
          iconCls: 'icon-add',
          handler: function () { newMenu() }
        },
        ]
      });
    });// end document ready 

    function setValue(id, text) {
      $('#selectedCategory').html("Selected Category : " + text);
      $('#parent_cc').combotree('setValue', id);
      $('#parent_cc').combotree('setText', text);
    }

    function submitNavmenuForm() {
      $.messager.progress({
        msg: '<img src="img/loading.gif">',
        border: false,
      });
      $.messager.progress('bar').hide();
      $('#frmNavmenu').form('submit', {
        url: updateNavmenuUrl,
        success: function (resp) {
          var data = jQuery.parseJSON(resp);
          $.messager.progress('close');
          if (data.result){
            $('#navTree').tree("reload");
            $('#frmNavmenu').form('clear');
            $('#selectedCategory').html('');
            $.messager.alert('', "Added New Menu successfully.", 'info');
          } else {
            $.messager.alert('', "Failed to add menu .", 'Warning');
          }
        }
      });
    }


    function newMenu() {
      $("#productReviewImageSrc").attr("src", "");
      $('#frmNavmenu').form('clear');
      $('#selectedCategory').html('');
      $("#menuid").textbox({readonly:false});
      $("#frmNavmenuAction").val("new");
    }
    function exportBanner() {
      $.messager.progress({
        msg: '<img src="img/loading.gif">',
        border: false,
      });
      $.messager.progress('bar').hide();
      $.ajax({
        url: exportPageBannerUrl,
        type: "GET",
        dataType: "json",
        success: function (resp) {
          $.messager.progress('close');
          if (resp.result) {
            $.messager.alert('', 'Banner has been exported successfully.', 'info');
            // alert("Banner has been exported successfully.");
          } else {
            $.messager.alert('', "Failed to export Banner.", 'Warning');
          }
        }
      });
    }
    function exportMenu() {
      $.messager.progress({
        msg: '<img src="img/loading.gif">',
        border: false,
      });
      $.messager.progress('bar').hide();
      $.ajax({
        url: export2022NavmenuUrl,
        type: "GET",
        dataType: "json",
        success: function (resp) {
          $.messager.progress('close');
          if (resp.result) {
            $.messager.alert('', "File has been exported successfully.", 'info');
          } else {
            $.messager.alert('', "Failed to export file.", 'Warning');
          }
        }
      });
    }
    function exportMarketingMenu() {
      $.messager.progress({
        msg: '<img src="img/loading.gif">',
        border: false,
      });
      $.messager.progress('bar').hide();
      $.ajax({
        url: exportMarketing2022NavmenuUrl,
        type: "GET",
        dataType: "json",
        success: function (resp) {
          $.messager.progress('close');
          if (resp.result) {
            $.messager.alert('', "File has been exported successfully.", 'info');
          } else {
            $.messager.alert('', "Failed to export file.", 'Warning');
          }
        }
      });
    }

    function updateFilterType() {
      $.messager.progress({
        msg: '<img src="img/loading.gif">',
        border: false,
      });

      var selectedFilterType = [];
      var fgdg = $('#filterType');
      $.map(fgdg.datagrid('getChecked'), function (row) {
          selectedFilterType.push(row.id);
      });
      var selectedMenucat = $('#navTree').tree('getSelected');
      fd = new FormData();
      fd.append('ktype', selectedFilterType.join(','));
      fd.append('menucat', selectedMenucat.id);
      $.messager.progress('bar').hide();
      $.ajax({
        url: updateFilterTypeToMenucatUrl,
        type: "POST",
        data: fd,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
          $.messager.progress('close');
          if (resp.result) {
            $.messager.alert('', 'Filter Type updated successfully.', 'info');

          } else {
            $.messager.alert('', "Failed to update Filter Type.", 'Warning');
          }
        }
      });
    }
  
  <?php echo '</script'; ?>
>
</body>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
