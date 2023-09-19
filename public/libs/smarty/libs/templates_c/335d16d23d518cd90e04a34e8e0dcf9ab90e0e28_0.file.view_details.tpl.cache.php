<?php
/* Smarty version 3.1.34-dev-7, created on 2023-09-05 10:53:50
  from '/akasa/www/marketing/templates/products/view_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64f708bebd9bb0_23129697',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '335d16d23d518cd90e04a34e8e0dcf9ab90e0e28' => 
    array (
      0 => '/akasa/www/marketing/templates/products/view_details.tpl',
      1 => 1693323396,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/navmenu.tpl' => 1,
    'file:products/mainInfo.tpl' => 1,
    'file:products/overview.tpl' => 1,
    'file:products/product_spec.tpl' => 1,
    'file:products/product_reviews.tpl' => 1,
    'file:products/upload_files.tpl' => 1,
    'file:socketform.tpl' => 1,
    'file:socketform_new.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_64f708bebd9bb0_23129697 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '193088043364f708bebc8ac8_97000706';
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
 type="text/javascript" src="/marketing/libs/angularJs-1.8.2/angular.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/marketing/libs/angularJs-1.8.2/angular-route.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/app.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/factory/dataFactory.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/ctrl/ProductDetailCtrl.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/service/fileService.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
 var _config = {
      partno: '<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
',
      id: '<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
      lang:getSessionLang(),
      aryFileTypes:'<?php echo $_smarty_tpl->tpl_vars['aryFileTypes']->value;?>
'
  };
  var fd = new FormData();
  var nfiles = 0;
  var deletedfile = [];
  var sockets = [];

  var notefd = new FormData();
  var notenfiles = 0;
  var notedeletedfile = [];
  var selected_folder = '';
  var webcode = '<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
';


  var lang = getSessionLang();

  $(document).ready(function () {
    //  dispheader();
    dispmainform();
    $('#p_introduction').panel({
      href: 'manproducts.php?action=showintroduction&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });
    $('#p_longdesc').panel({
      href: 'manproducts.php?action=showlongdesc&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });
    $('#p_shortdesc').panel({
      href: 'manproducts.php?action=showshortdesc&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });
    $('#p_shortdesc1').panel({
      href: 'manproducts.php?action=showshortdesc1&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });
    $('#p_shortdesc2').panel({
      href: 'manproducts.php?action=showshortdesc2&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });
    $('#p_note').panel({
      href: 'manproducts.php?action=shownote&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
    });


    $('#folderlist').tree({
      dnd: true,
      onClick: function (node) {
        selected_folder = node.id;
        var url = "manfile_easyui.php?action=listfile&dir=" + node.id;
        lastWord = node.id.split('/').pop();
        console.log(lastWord);
        if (lastWord == "Links") {
          columnsOpt = [[
            { field: 'filename', title: 'Link', width: 250 },
            {
              field: 'action', title: 'Action', width: 50, align: 'center',
              formatter: function (value, row, index) {
                return '<a href="javascript:void(0)" onclick="deleteLink(' + index + ',\'' + row.webpath + '\')">Delete</a>';
              }
            }
          ]];
        } else { // default 
          columnsOpt = [[
            { field: 'filename', title: 'Name 檔名', width: 220 },
            { field: 'filesize', title: 'Size 大小', width: 120 },
            { field: 'filedate', title: 'Date 日期', width: 150 }
          ]];
        }

        // check the folder name with links
        $("#filelist").datagrid({
          url: url,
          columns: columnsOpt,
          onLoadSuccess: function () {
            $(this).datagrid('enableDnd');
            var dg = $(this);
            var opts = $(this).datagrid('options');
            var trs = opts.finder.getTr(this, 0, 'allbody');
            trs.draggable({
              revert: true,
              deltaX: 15,
              deltaY: 15,
              proxy: function (source) {
                var index = parseInt($(this).attr('datagrid-row-index'));
                var title = dg.datagrid('getRows')[index]['itemid'];
                var p = $('<div class="tree-node-proxy"></div>').appendTo('body');
                p.html('<span class="tree-dnd-icon tree-dnd-no">&nbsp;</span>' + title);
                return p;
              }
            });
          },
        });
        $("#fileamalist").datagrid("reload");
      },
      onLoadSuccess: function () {
        $(this).find('.tree-node').each(function () {
          var opts = $(this).droppable('options');
          opts.accept = '.tree-node,.datagrid-row';
          var onDragEnter = opts.onDragEnter;
          var onDragOver = opts.onDragOver;
          var onDragLeave = opts.onDragLeave;
          var onDrop = opts.onDrop;
          opts.onDragEnter = function (e, source) {
            if ($(source).hasClass('tree-node')) {
              onDragEnter.call(this, e, source);
            }
          };
          opts.onDragOver = function (e, source) {
            if ($(source).hasClass('tree-node')) {
              onDragOver.call(this, e, source);
            } else {
              allowDrop(source, true);
              $(this).removeClass('tree-node-append tree-node-top tree-node-bottom');
              $(this).addClass('tree-node-append');

            }
          };
          opts.onDragLeave = function (e, source) {
            if ($(source).hasClass('tree-node')) {
              onDragLeave.call(this, e, source);
            } else {
              allowDrop(source, false);
              $(this).removeClass('tree-node-append tree-node-top tree-node-bottom');
            }
          };
          opts.onDrop = function (e, source) {
            //console.log("opts - onDrop");
            // console.log(this);
            //console.log(source);
            var toFolderId = $(this).attr("id");
            var toFolderPath = "";
            var toFolderShort = "";
            var t = $('#folderlist');
            var children = t.tree('getChildren');
            for (var i = 0; i < children.length; i++) {
              var node = children[i];
              if (node.domId == toFolderId) {

                toFolderPath = node.id;
                var pnode = t.tree('getParent', node.target);
                if (pnode) {
                  toFolderShort = pnode.text + '/' + node.text;
                }
              }
            }
            // onDrop.call(this, e, arySource);
            // do ajax
            fd.append('dirname', $(source).find('td:eq(0)').text());
            fd.append('webpath', $(source).find('td:eq(1)').text());
            fd.append('filename', $(source).find('td:eq(2)').text());
            fd.append('to_folder', toFolderPath);
            fd.append('to_folder_short', toFolderShort);
            $.ajax({
              url: 'manfile_easyui.php?action=drop_file&webcode=webcode',
              enctype: 'multipart/form-data',
              type: 'post',
              data: fd,
              async: true,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function (response) {
                // console.log(response);
                $("#filelist").datagrid("reload");
              }
            });

            /*  if ($(this).hasClass('tree-node')) {
                console.log("checked");
                onDrop.call(this, e, source);
              } else {
  
              }
              */
          };
          function allowDrop(source, allowed) {
            var icon = $(source).draggable('proxy').find('span.tree-dnd-icon');
            icon.removeClass('tree-dnd-yes tree-dnd-no').addClass(allowed ? 'tree-dnd-yes' : 'tree-dnd-no');
          }
        })
      }
    });

    $('#filelist').datagrid({
      onDblClickRow: function (rowIndex, row) {
        if (row.dirname == "gotolink") {
          OpenInNewTab(row.filename);
        } else {
          var filename = row.filename;
          var webpath = row.webpath;
          previewFileInDlg(row.filename, webpath + '/' + filename);
        }
      },
    });

    // preventing page from redirecting
    $("html").on("dragover", function (e) {
      e.preventDefault();
      e.stopPropagation();
    });

    $("html").on("drop", function (e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('#uploadarea').on('dragenter', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });

    // Drag over
    $('#notefileuploadarea').on('dragover', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });

    // Drop
    $('#uploadarea').on('drop', function (e) {
      e.stopPropagation();
      e.preventDefault();

      console.log('number files drop ' + e.originalEvent.dataTransfer.files.length);
      var file = e.originalEvent.dataTransfer.files;
      j = nfiles + 1;
      for (var i = 0; i < e.originalEvent.dataTransfer.files.length; i++) {
        k = i + j;
        fd.append('file_' + k, file[i]);
        $('#fileuploadlist').datagrid('appendRow', { itemid: k, filename: file[i].name });
        nfiles++;
      }
    });
    // Drop to note file upload area
    $('#notefileuploadarea').on('drop', function (e) {
      e.stopPropagation();
      e.preventDefault();

      console.log('number files drop ' + e.originalEvent.dataTransfer.files.length);
      var file = e.originalEvent.dataTransfer.files;
      j = notenfiles + 1;
      for (var i = 0; i < e.originalEvent.dataTransfer.files.length; i++) {
        k = i + j;
        notefd.append('file_' + k, file[i]);
        $('#notefileuploadlist').datagrid('appendRow', { itemid: k, filename: file[i].name });
        notenfiles++;
      }
    });
    $('#introduction_id').summernote({
      tabsize: 2,
      width: 800,
      height: 520,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });

    $('#introform_intro_display_type').combo({
      required: true,
      editable: false,
      label: 'Display Style:',
      labelPosition: 'left',
      labelWidth: '120px'
    });
    // $('#introform-sp').appendTo($('#introform-cc').combo('panel'));
    $('#introform-sp input').click(function () {
      var v = $(this).val();
      var s = $(this).next('span').text();
      $('#introform-cc').combo('setValue', v).combo('setText', s).combo('hidePanel');
    });

    $('#shortdesc_id').summernote({
      tabsize: 2,
      width: 800,
      height: 180,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });
    $('#shortdesc1_id').summernote({
      tabsize: 2,
      width: 800,
      height: 180,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });
    $('#shortdesc2_id').summernote({
      tabsize: 2,
      width: 800,
      height: 180,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });
    $('#longdesc_id').summernote({
      tabsize: 2,
      width: 800,
      height: 180,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });
    $('#spechtml_id').summernote({
      tabsize: 2,
      width: 800,
      height: 580,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });
    $('#note_id').summernote({
      tabsize: 2,
      width: 800,
      height: 180,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['codeview', 'help']]
      ]
    });

    $('#supportTabs').tabs({
      tabPosition: 'left', border: false,
      fit: true, plain: true,
      headerWidth: 255
    })

    $('#frmCopyProduct_new_partno').tagbox();
    $.extend($.fn.datagrid.defaults.editors, {
      tagbox: {
        init: function (container, options) {
          var input = $('<input>').appendTo(container);
          input.tagbox(options);
          return input;
        },
        destroy: function (target) {
          $(target).tagbox('destroy');
        },
        getValue: function (target) {
          return $(target).tagbox('getValues').join(',');
        },
        setValue: function (target, value) {
          if (value) {
            $(target).tagbox('setValues', value.split(','));
          } else {
            $(target).tagbox('clear');
          }
        },
        resize: function (target, width) {
          $(target).tagbox('resize', width);
        }
      }
    })



  }); // end document ready

  function addsubfolder() {
    var node = $("#folderlist").tree("getSelected");
    if (node == null) {
      //    alert("請選文件夾!");
      var parent = "<?php echo $_smarty_tpl->tpl_vars['docpath']->value;?>
";
    } else {
      var parent = node.id;
    }
    var foldername = $("#fmsubfolder").textbox().textbox('getValue');
    console.log(foldername);
    if (foldername) {
      $("#fmsubfolder").textbox().textbox('clear');
      var url = "manfile_easyui.php?action=mkdir&parent=" + parent + "&subfolder=" + foldername;
      $.getJSON(url, function (data) {
        $("#folderlist").tree("reload");
        var url = "manfile_easyui.php?action=listfile";
        $("#filelist").datagrid({ url: url });
        $("#filelist").datagrid("reload");
      });

    } else {
      alert("Please enter a folder name.");
    }

  }

  function dispmainform() {
    $.ajax({
      url: "manproducts.php?action=gethddisplay&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      type: "GET",
      dataType: "json",
      success: function (data) {
        $('#mfdisplay').form('load', data);
        if (data.active == '1') {
          $('#mfd_active').checkbox('check');
        } else {
          $('#mfd_active').checkbox('uncheck');
        }
        if (data.iscooler == '1') {
          $('#mfd_iscooler').checkbox('check');
        } else {
          $('#mfd_iscooler').checkbox('uncheck');
        }
        if (data.newproduct == '1') {
          $('#mfd_newproduct').checkbox('check');
        } else {
          $('#mfd_newproduct').checkbox('uncheck');
        }
        if (data.displaypartnoline == '1') {
          $('#mfd_displaypartnoline').checkbox('check');
        } else {
          $('#mfd_displaypartnoline').checkbox('uncheck');
        }
        if (data.listpic) {
          var path = '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Gallery/';
          $("#listpic").attr("src", path + data.listpic.docname);
        }
      }
    });
  }
  function editkeyword() {
    $.ajax({
      url: "manproducts.php?action=getkeyword&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      type: "GET",
      dataType: "json",
      success: function (data) {
        $('#keywordform').form('load', data);
        $('#keywordformdlg').dialog('open');
      },
    });
  }
  function editChkboxkeyword() {
    $('#keywordlistselection').datagrid("reload");
    $('#dlgcheckboxkeywordlist').dialog('open');

  }
  function submitkeywordform() {
    $('#keywordform').form('submit', {
      url: 'manproducts.php?action=savekeyword',
      success: function (data) {
        $('#keywordformdlg').dialog('close');
        dispmainform();
      }
    });
  }
  function cancelkeywordform() {
    $('#keywordformdlg').dialog('close');
  }

  function submitkeywordlistform() {

    var selectedIds = '';
    var kldg = $('#keywordlistselection');
    $.map(kldg.datagrid('getChecked'), function (row) {
      if (selectedIds) {
        selectedIds = selectedIds.concat(",", row.id);
      } else {
        selectedIds = row.id;
      }
    });
    //console.log(JSON.stringify(selectedIds));
    fd = new FormData();
    fd.append('selectedIds', selectedIds);
    fd.append('partno', '<?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
');
    $.ajax({
      url: 'mankeywordlist.php?action=saveprodkeywords',
      enctype: 'multipart/form-data',
      type: 'post',
      data: fd,
      async: true,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {
        $('#keywordlistform').form('clear');
        $('#dlgcheckboxkeywordlist').dialog('close');
        // $("#filelist").datagrid("reload");
      }
    });
    fd = new FormData();
    // $('#keywordlistform').form('submit', {
    //   url: 'manproducts.php?action=savekeyword',
    //   success: function (data) {
    //     $('#dlgcheckboxkeywordlist').dialog('close');
    //     dispmainform();
    //   }
    // });
  }
  function cancelkeywordlistform() {
    $('#keywordlistform').form('clear');
    $('#dlgcheckboxkeywordlist').dialog('close');
  }

  function editmain() {
    $.ajax({
      url: "manproducts.php?action=getmainform&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      type: "GET",
      dataType: "json",
      success: function (data) {
        $('#mainform').form('load', data);
        if (data.active == '1') {
          $('#mf_active').checkbox('check');
        } else {
          $('#mf_active').checkbox('uncheck');
        }
        if (data.newproduct == '1') {
          $('#mf_newproduct').checkbox('check');
        } else {
          $('#mf_newproduct').checkbox('uncheck');
        }
        if (data.iscooler == '1') {
          $('#mf_iscooler').checkbox('check');
        } else {
          $('#mf_iscooler').checkbox('uncheck');
        }
        if (data.displaypartnoline == '1') {
          $('#mf_displaypartnoline').checkbox('check');
        } else {
          $('#mf_displaypartnoline').checkbox('uncheck');
        }
        $('#mainformdlg').dialog('open');
      }
    });
  }

  function set_cb_value(cb_elm, cb_elm_value) {
    var opts = cb_elm.checkbox('options');
    if (opts.checked) {
      cb_elm_value.val('1');
    } else {
      cb_elm_value.val('0');
    }
  }
  function submitMainForm() {
    // set mainform checkbox value for checked or non-checked
    // this is required as form does not send checkbox value if not checked
    set_cb_value($('#mf_active'), $('#mfv_active'));
    set_cb_value($('#mf_iscooler'), $('#mfv_iscooler'));
    set_cb_value($('#mf_newproduct'), $('#mfv_newproduct'));
    set_cb_value($('#mf_displaypartnoline'), $('#mfv_displaypartnoline'));

    $('#mainform').form('submit', {
      url: 'manproducts.php?action=savemainform',
      success: function (data) {
        $('#mainformdlg').dialog('close');
        dispmainform();
      }
    });
  }
  function cancelMainForm() {
    $('#mainformdlg').dialog('close');
  }

  function export2oldweb() {
    $.ajax({
      url: "exportproduct_detail.php?partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      type: "GET",
      dataType: "json",
      success: function (data) {
        //       OpenInNewTab('/akasa10/search.php?seed=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
        alert("Success: upload to akasa10 web!");
      }
    });

  }
  function copyProduct() {
    $('#frmCopyProduct_old_partno').textbox('setValue', '<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');

    // show modal to input the new partno
    $('#dlgCopyProduct').dialog('open');
    // initial textbox
  }

  function frmCopyProduct_checkall() {

    $('#frmCopyProduct_chbox_prod_spec').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_product_details').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_images').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_reviews').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_support').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_faq').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_download').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_product_tag_xref').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_prodlist_boxes').checkbox({ checked: true });
    $('#frmCopyProduct_chbox_oldprodlist_box').checkbox({ checked: true });
  }
  function frmCopyProduct_uncheckall() {

    $('#frmCopyProduct_chbox_prod_spec').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_product_details').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_images').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_reviews').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_support').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_faq').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_download').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_product_tag_xref').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_prodlist_boxes').checkbox({ checked: false });
    $('#frmCopyProduct_chbox_oldprodlist_box').checkbox({ checked: false });
  }
  function submitCopyProductForm() {
    $('#frmCopyProduct_lang').val('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
    $('#frmCopyProduct').form('submit', {
      url: 'manproducts.php?action=check_partno',
      success: function (resp) {
        var aryResp = JSON.parse(resp);
        console.log(aryResp.result);
        if (aryResp.result) {

          var text = '';
          if (aryResp.data.hasOwnProperty('new')) {
            for (let i = 0; i < aryResp.data.new.length; i++) {
              if (aryResp.data.new[i]) {
                text += aryResp.data.new[i] + " -- (Create)<br>";
              }
            }
          }
          if (aryResp.data.hasOwnProperty('existing')) {
            for (let i = 0; i < aryResp.data.existing.length; i++) {
              if (aryResp.data.existing[i]) {
                text += aryResp.data.existing[i] + "&nbsp;&nbsp;(Copy)<br>";
              }
            }
          }

          $.messager.confirm('Confirm', 'Are you sure to ... <br><b>' + text + '</b><br><br><img src="/icons-main/icons/exclamation-triangle.svg">&nbsp;&nbsp;Data will be overwritted.', function (r) {
            if (r) {
              $('#frmCopyProduct_confirmed').val(true);
              $('#frmCopyProduct').form('submit', {
                url: 'manproducts.php?action=copy_partno',
                success: function (resp) {
                  var aryResp = JSON.parse(resp);
                  console.log(aryResp);
                  if (aryResp.result) {
                    var text = "";
                    for (let i = 0; i < aryResp.data.length; i++) {
                      if (aryResp.data[i]) {
                        text += aryResp.data[i];
                        if (i + 1 < aryResp.data.length) {
                          text += ",";
                        }
                      }
                    }
                    $.messager.alert('Finished', " Completed : " + text, 'info');
                    cancelCopyProductForm();
                  } else {
                    $.messager.alert('Failed', aryResp.data, 'error');
                  }
                }
              });//END submit copy_partno

            } // end of if confirm
          }, 'warning'); // end of confirm messager

          // end 
        } else {
          // no partno error
          $.messager.alert('Failed', aryResp.data, 'error');
        }
      }
    });// END submit


  }
  function cancelCopyProductForm() {
    $('#frmCopyProduct').form('clear');
    $('#dlgCopyProduct').dialog('close');
  }

  function export2206web() {
    fd.append('partno', '<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
    $.ajax({
      url: export2206webApi,
      enctype: 'multipart/form-data',
      type: 'post',
      data: fd,
      dataType: "json",
      async: true,
      contentType: false,
      processData: false,
      success: function (resp) {
        console.log(resp);
        alert("Success: upload to akasa2206 web!");
      }
    });
  }
  function pageReloadDatagrid(){
    console.log(window.location.href); 
    var href = new URL(window.location.href);
    href.searchParams.set('lang', getSessionLang());
    console.log(href.toString());
    window.location.replace(href.toString());
  }

    // review site
    var loadreviewsite = function(param,success,error){
            var q = param.q || '';
            if (q.length <= 2){return false}
              $.ajax({
              url: backendApi+'/reviewsites/get_name/'+q,
              dataType: 'json',
              data: {
                q: q
              },
              success: function(data){
                var items = $.map(data, function(item){
                return {
                  id: item.id,
                  name: item.name
                  };
                });
                success(items);
              },
            error: function(){
              error.apply(this, arguments);
            }
            });
          }

<?php echo '</script'; ?>
>
<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid" ng-controller="ProductDetailCtrl">
    <div class="row">
      <div class="col h5">
        Product: <?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
 &nbsp;
        <a href="javascript:void(0)" class="btn btn-sm btn-primary" iconCls="icon-box-arrow-left" plain="true"
          onclick="export2oldweb()"><i class="bi bi-file-arrow-down"></i>&nbsp;Export to akasa10 WebPage</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="export2206web()"><i
            class="bi bi-file-arrow-down"></i>&nbsp;Export to akasa2206 WebPage</a>
        <a href="../akasa2206/update.php?tpl=product/product.detail.tpl&&model=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
"
          class="btn btn-sm btn-orange" target="_blank"><i class="bi bi-eye-fill"></i>&nbsp;View Detail Page (Akasa
          2206)
        </a>
        <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="copyProduct()"><i
            class="bi bi-files"></i>&nbsp;Copy Product</a>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <!-- Begin of tabs -->
        <div class="easyui-tabs" style="width:1750px;height:870px;" class="border border-orange" id="tt">
          
        <?php $_smarty_tpl->_subTemplateRender('file:products/mainInfo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php $_smarty_tpl->_subTemplateRender('file:products/overview.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
         <!-- old introduction tab 
          <div title="Introduction" data-options="iconCls:'icon-chat-right-text'">
            <a href="javascript:void(0)" id="bteditintroduction" class="easyui-linkbutton" iconCls="icon-pencil"
              plain="true" onclick="editintroduction()">Edit Introduction</a>
            <div style="width:800px;"><input id="bteditintroduction-cc1" name="intro_display_type"
                class="easyui-combobox" data-options="valueField: 'id',textField: 'text',label:'Display Type:',labelPosition:'left',labelWidth:'140px',width:'100%',disabled: true,labelAlign:'right',
          url: 'manproducts.php?action=intro_display_options&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
          "></div>
            <div id="p_introduction" class="easyui-panel" style="width:800px;height:650px;">
            </div>
          </div>
        -->

          <!-- product_spec.tpl-->
          <?php $_smarty_tpl->_subTemplateRender('file:products/product_spec.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <?php $_smarty_tpl->_subTemplateRender('file:products/product_reviews.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

          <div title="Support" data-options="iconCls:'icon-upload'">
            <div id="supportTabs" class="easyui-tabs" data-options="tabWidth:250" style="width:1850px; height:400px;">
              <div title="Software and Manual" data-options="iconCls:'icon-upload',tabWidth:250">
                <table id="downloadlist" style="width:1390px; height:400px;" class="easyui-datagrid"
                  title="Software Manual"
                  data-options="singleSelect:true,pagination:true,pageSize:'10',sortORder:'asc',sortName:'seqno', url:'mandownload.php?action=list&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
&imgtype=Download&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',toolbar:'#download_toolbar'">
                  <thead>
                    <tr>
                      <th data-options="field:'id',sortable:true,width:40,hidden:true,title:'ID'"></th>
                      <th data-options="field:'seqno',sortable:true,width:60,title:'Seqno'"></th>
                      <th data-options="field:'subject',sortable:true,width:300,title:'Subject'"></th>
                      <th data-options="field:'docname',sortable:true,width:300,title:'File Name'"></th>
                      <th data-options="field:'ftype',width:100,title:'File Type'"></th>
                      <th data-options="field:'releasedate',width:120,title:'Release Date'"></th>
                      <th data-options="field:'comment',width:600,title:'Comment'"></th>
                    </tr>
                  </thead>
                </table>
                <div id='download_toolbar'>
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-plus" plain="true"
                    onclick="editdownload('-1')">Add</a>
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-pencil" plain="true"
                    onclick="editdownload('0')">Edit</a>
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-trash" plain="true"
                    onclick="deletedownload()">Delete</a>
                </div>
              </div>

              <div title="FAQ" data-options="iconCls:'icon-question',tabWidth:250">
                <table id="faqlist" style="width:1390px; height:400px;"></table>
                <div id="faqtoolbar">
                  <a id="btaddfaq" href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-plus" plain="true"
                    onclick="editfaq('0')">Add</a>
                  <a id="bteditfaq" href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-pencil"
                    plain="true" onclick="editfaq('1')">Edit</a>
                  <a id="bteditfaq" href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-trash"
                    plain="true" onclick="delfaq()">Delete</a>
                </div>
              </div>
              <div title="Note" data-options="iconCls:'icon-file-text'">
                <a href="javascript:void(0)" id="bteditdesc" class="easyui-linkbutton" iconCls="icon-pencil"
                  plain="true" onclick="editnote()">Edit Note</a>
                <div id="p_note" class="easyui-panel" title="Note" style="width:1390px; height:400px;">
                </div>
              </div>
            </div>
          </div>



          <div title="Gallery" data-options="iconCls:'icon-image'">
            <table id="gallerylist" class="easyui-datagrid" title="Gallery"
              data-options="singleSelect:'true',pagination:'true',pageSize:'10',sortORder:'asc',sortName:'seqno', width:'1200',height:'800', url:'manimages.php?action=list&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
&imgtype=Gallery&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',toolbar:'#gallery_toolbar'">
              <!--thead>
    <tr>
    <th field="id" width="40" sortable="true" hidden=true>ID</th>
    <th field="docname" width="80" sortable="true">File Name</th>
    <th field="seqno" width="80" sortable="true" >Seqno</th>
    <th field="caption" width="80" >Caption</th>
    <th field="comment" width="80" >Comment</th>
    </tr>
    </thead-->
            </table>
            <div id='gallery_toolbar'>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange"
                onclick="editimage('Gallery','-1')"><i class="bi bi-plus"></i>&nbsp;Add Image</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange"
                onclick="editimage('Gallery','0')"><i class="bi bi-pencil"></i>&nbsp;Edit Image</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange"
                onclick="delimage('Gallery', '#gallerylist')"><i class="bi bi-trash"></i>&nbsp;Delete Image</a>
            </div>
          </div>


          <!-- Begin Docs tab -->
          <div title="Documents" data-options="iconCls:'icon-files'">
            <div class="easyui-layout" style="width:1300px;height:600px;">
              <div data-options="region:'west',split:true,iconCls:'icon-folder'" title="Folders 文件夾"
                style="width:200px;">
                <ul id="folderlist" class="easyui-tree" url="manfile_easyui.php?action=listfolder&id=<?php echo $_smarty_tpl->tpl_vars['docpath']->value;?>
">
                </ul>
              </div>
              <div data-options="region:'center',split:true,iconCls:'icon-files'" title="Files 文檔列表"
                style="width:650px;">
                <table id="filelist" class="easyui-datagrid" style="width:748px;height:567px" data-options="
                    singleSelect:true,fitColumns:'true',
                    toolbar:'#filelisttoolbar',
                    pagination:true,
                    pageSize: 10,
                    pageList: [10,20,30],
                    nowrap:'false',
                    collapsible:true,
                    nowrap:false,
                    url:'manfile_easyui.php?action=listfile'
                    ">
                  <thead>
                    <tr>
                      <!--th field="ck" checkbox="true"></th-->
                      <th field="dirname" width="20" hidden="true">DIR</th>
                      <th field="webpath" width="20" hidden="true">WP</th>
                      <th field="filename" width="220" sortable="true">Name 檔名</th>
                      <th field="filesize" width="120" sortable="true">Size 大小</th>
                      <th field="filedate" width="150">Date 日期</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="filelisttoolbar">
                <input class="easyui-textbox" name="subfolder" id="fmsubfolder" style="width:250px"
                  data-options="label:'Folder 文件夾:',labelWidth:'105px'">
                <a href="#" class="btn btn-sm btn-orange"
                  onclick="addsubfolder()"><i class="bi bi-bag-plus"></i>&nbsp;New
                  Folder 新文件夾</a>
                <a href="#" class="btn btn-sm btn-orange" onclick="removefile()"><i class="bi bi-trash"></i>&nbsp;Remove
                  File
                  删除文件</a>
                <a href="#" class="btn btn-sm btn-orange" onclick="openAddLinks()"><i class="bi bi-plus"></i>&nbsp;Add
                  Links</a>
              </div>
              <div data-options="region:'east',split:true,iconCls:'icon-upload'" title="Upload Files 上載文件"
                style="width:350px;">
                <div id="uploadarea">
                  <table id="fileuploadlist" class="easyui-datagrid" style="width:343px;height:520px" data-options="
                      singleSelect:true,
                      fitColumns:'true',
                      toolbar:'#uploadfiletoolbar',
                      pagination:false,
                      pageSize: 10,
                      pageList: [10,20,30],
                      nowrap:'false',
                      collapsible:true
                      ">
                    <thead>
                      <tr>
                        <th field="itemid" width="50">id</th>
                        <th field="filename" width="150">file upload</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div id="uploadfiletoolbar" style="padding:3px">
                  <input type="file" name="uploadFile" id="uploadFile" style="display:none;">
                  <a class="btn btn-sm btn-orange"
                    onclick="document.getElementById('uploadFile').click()" value="Select a File"><i class="bi bi-file-check"></i>&nbsp;Select File 選擇文檔</a>
                  <a class="btn btn-sm btn-orange" onclick="removerow()"><i class="bi bi-trash"></i>&nbsp;Remove 删除</a>
                </div>
                <div style="text-align:center;padding:5px 0">
                  <a href="javascript:void(0)" class="btn btn-sm btn-orange"
                    onclick="submituploadfile()" style="width:120px"><i class="bi bi-file-arrow-up"></i>&nbsp;Submit 提交</a>
                  <a href="javascript:void(0)" class="btn btn-sm btn-orange"
                    onclick="canceluploadfile()" style="width:120px"><i class="bi bi-x"></i>&nbsp;Cancel 取消</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End of Docs tab -->
          <!-- Published list tab-->
          <?php $_smarty_tpl->_subTemplateRender('file:products/upload_files.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <!-- End published list tab-->
        </div>
        <!-- End of tabs -->
      </div>
      <!-- add modalhere-->
      <no-selection-directive></no-selection-directive>
      <msg-modal-directive></msg-modal-directive>
                  <!-- Begin of Review Icon Form Dialog -->
                  <div class="modal fade" id="reviewiconformModal" tabindex="-1" aria-labelledby="reviewiconformModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">{#iconData.formname#}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form id="reviewiconform" enctype="multipart/form-data" method="post">
                              <input type="text" id="rif_id" name="id" hidden=true>
                              <input type="text" id="rif_partno" name="partno" hidden=true>
                              <input type="text" id="rif_lang" name="lang" hidden=true>
                              <div class="form-group row">
                                <label for="i_sitename" class="col-sm-2 col-form-label text-end">Site Name *</label>
                                <div class="col-sm-9">
                                  <input name="sitename"  id="i_sitename" class="form-control  form-control-sm border-orange mt-1" ng-model="iconData.sitename">
                                  <span ng-show="iconData.invalid_sitename" class="text-danger fs-6">Site Name
                                    is required</span>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="i_siteurl" class="col-sm-2 col-form-label text-end">Website </label>
                                <div class="col-sm-9">
                                  <input name="siteurl"  id="i_siteurl" class="form-control  form-control-sm border-orange mt-1" ng-model="iconData.siteurl" placeholder="suggest having url">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="i_comment" class="col-sm-2 col-form-label text-end">Comment</label>
                                <div class="col-sm-9">
                                  <input name="comment"  id="i_comment" class="form-control  form-control-sm border-orange mt-1" ng-model="iconData.comment">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="i_comment" class="col-sm-2 col-form-label text-end">Icon File</label>
                                <div class="col-sm-9">
                                  <input type="file" file-uploads-model="iconData.myIcon" class="form-control"
                                  id="uploadIcon" />
                                  <span ng-show="iconData.invalid_myIcon" class="text-danger fs-6">Logo
                                    is required</span>
                                </div>
                              </div>
                              <div class="form-group row" ng-if="iconData.sitelogo">
                                <label for="i_comment" class="col-sm-2 col-form-label text-end">Current icon</label>
                                <div class="col-sm-9">
                                  <img src="./{#config.iconpath#}{#iconData.sitelogo#}" class="img-fluid">
                                </div>
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="submitReviewIconForm()">Save</button>
                          </div>
                      </div>
                  </div>
              </div>
                  <div class="easyui-dialog" id="reviewiconformdlg" data-options="resizable:true"
                  style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons"
                  title="Edit Review Icon">
                  <form id="reviewiconform" enctype="multipart/form-data" method="post">
                    <input type="text" id="rif_id" name="id" hidden=true>
                    <input type="text" id="rif_partno" name="partno" hidden=true>
                    <input type="text" id="rif_lang" name="lang" hidden=true>
                    <p>
                    <div id="rim_file">
                      <input class="easyui-filebox" name="iconfile" style="width:450px;"
                        data-options="prompt:'Choose a file...',label:'Icon File:',labelWidth:'100px',labelPosition:'before',labelAlign:'right'">
                      <p>
                    </div>
                    <input class="easyui-textbox" name="sitename" style="width:450px;"
                      data-options="label:'Site Name:',labelPosition:'before',labelWidth:'100px;',labelAlign:'right'">
                    <p>
                      <input class="easyui-textbox" name="siteurl" style="width:450px;"
                        data-options="label:'Web Site:',labelPosition:'before',labelWidth:'100px;',labelAlign:'right'">
                    <p>
                      <input class="easyui-textbox" name="comment" style="width:450px;height:90px;"
                        data-options="label:'Comment:',labelPosition:'top',multiline:'true'">
                  </form>
    
                  <div style="text-align:center;padding:5px 0">
                    <a href="javascript:void(0)"  class="btn btn-orange btn-sm"
                      ng-click="submitReviewIconForm()">Save</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelReviewIconForm()"
                      style="width:80px">Cancel</a>
                  </div>
                </div>
                <!-- End of Review Icon Form Dialog -->
    </div>

<!-- Begin of copy product Form Dialog JM-->
<div class="easyui-dialog" id="dlgCopyProduct" data-options="resizable:true"
  style="width:550px;height:550px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Copy Product">
  <form id="frmCopyProduct" enctype="multipart/form-data" method="post">
    <input type="text" id="frmCopyProduct_lang" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
" hidden=true>
    <input type="text" id="frmCopyProduct_confirmed" name="confirmed" value="false" hidden=true>
    <p><b>
        <input class="easyui-textbox" id="frmCopyProduct_old_partno" name="old_partno" style="width:400px;"
          data-options="label:'Original Partno:',labelWidth:'140px',labelAlign:'right',readonly:true">
      </b></p>

    <p><b>
        <input class="easyui-tagbox" id="frmCopyProduct_new_partno" name="new_partno[]" style="width:400px;"
          data-options="label:'New Partno:',labelWidth:'140px',labelAlign:'right',
          icons: [{
            iconCls:'icon-clear',
            handler: function(e){
                $(e.data.target).tagbox('clear');
            }
        }],tagFormatter: function(value, row){
          return '[' + value + ']';
      }">
      </b><br><span style="padding-left:140px">Hit "Enter" to separate partno.</span></p>
    <hr>
    <p> <b>Copy or Create data : </b><a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-check"
        onclick="frmCopyProduct_checkall()">Check all</a>&nbsp;&nbsp;<a href="javascript:void(0);"
        class="easyui-linkbutton" class="easyui-linkbutton" iconCls="icon-x" onclick="frmCopyProduct_uncheckall()">
        Uncheck all</a></p>
    <!-- check box -->


    <table>
      <tr>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_prod_spec" name="prod_spec" value="1"
              data-options="label:'Product Specification:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_product_details" name="product_details" value="1"
              data-options="label:'Product Details:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_images" name="images" value="1"
              data-options="label:'Images:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_reviews" name="reviews" value="1"
              data-options="label:'Reviews:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>

      </tr>
      <tr>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_faq" name="faq" value="1"
              data-options="label:'Faq:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_download" name="download" value="1"
              data-options="label:'Download:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>
        <td>
      </tr>
      <tr>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_product_tag_xref" name="product_tag_xref" value="1"
              data-options="label:'Tag:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>
        <td>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" id="frmCopyProduct_chbox_prodlist_boxes" name="prodlist_boxes" value="1"
              data-options="label:'Akasa2206 Box:',labelWidth:'160px',labelAlign:'right',checked:true">
          </div>
        </td>

      </tr>
    </table>
  </form>

  <div style="text-align:center;padding:5px 0">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitCopyProductForm()" style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelCopyProductForm()"
      style="width:80px">Cancel</a>
  </div>
</div>
<!-- End of copy product Form Dialog -->
<!-- Begin of review Form Dialog JM-->
<div class="easyui-dialog" id="dlgProductReviews" data-options="resizable:true"
  style="width:850px;height:800px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit Product Reviews">
  {#addProdReviewsData#}
  <form id="reviewform" method="post">
    <div class="form-group row">
      <label for="rf_title" class="col-sm-2 col-form-label text-end">Title *</label>
      <div class="col-sm-9">
        <input name="title"  id="rf_title" class="form-control  form-control-sm border-orange mt-1" ng-model="addProdReviewsData.title">
        <div class="invalid-feedback">More example invalid feedback text</div>
      </div>
    </div>
    <div class="form-group row">
      <label for="rf_seqno" class="col-sm-2 col-form-label text-end">Seqno</label>
      <div class="col-sm-4">
        <input name="title" id="rf_seqno"  placeholder="0010" class="form-control  form-control-sm border-orange mt-1" ng-model="addProdReviewsData.seqno"  ng-maxlength="4"> 
      </div>
      <label for="rf_is_highlight" class="col-sm-1 col-form-label text-end"></label>
      <div class="col-sm-4">
        <div class="form-check">
          <input class="form-check-input border-orange mt-3" type="checkbox" id="rf_is_highlight"  name="is_highlight" value="1"  ng-model="addProdReviewsData.is_highlight">
          <label class="form-check-label  mt-2" for="is_highlight">
            is Large Box?
          </label>
        </div>
      </div>
    </div>
    
    <div class="form-group row">
      <label for="rf_title" class="col-sm-2 col-form-label text-end">Type *</label>
      <div class="col-sm-9">
        <div class="form-check form-check-inline mt-1" ng-repeat="optValue in prodReviewsTypes">
          <input class="form-check-input" type="radio" name="type" value="optValue" ng-model="addProdReviewsData.type" ng-value="optValue">
          <label class="form-check-label" for="inlineRadio3">{#optValue#}</label>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label for="rf_title" class="col-sm-2 col-form-label text-end">Web link *</label>
      <div class="col-sm-9">
        <input name="title"  id="rf_title" class="form-control  form-control-sm border-orange mt-1" ng-model="addProdReviewsData.web_link">
      </div>
    </div>

    <div class="form-group row my-1">
      <label for="rf_title" class="col-sm-2 col-form-label text-end">Short desc *</label>
      <div class="col-sm-9">
        <textarea class="form-control border-orange"form-control-sm placeholder="Leave a Short Description" id="rf_short_desc" style="height: 100px" ng-model="addProdReviewsData.short_desc"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="rf_title" class="col-sm-2 col-form-label text-end">Remarks</label>
      <div class="col-sm-9">
        <input name="remarks"  id="rf_remarks" class="form-control  form-control-sm border-orange mt-1" ng-model="addProdReviewsData.remarks" placeholder="(e.g. dd-mm-yyyy)">
      </div>
    </div>
    <hr>
    <div class="form-group row">
      <label for="rf_image_file" class="col-sm-2 col-form-label text-end">Image File</label>
      <div class="col-sm-9">
        <input type="file" class="form-control-file" id="rf_image_file">
      </div>
    </div>
    <div class="form-group row">
      <label for="rf_image_caption" class="col-sm-2 col-form-label text-end">Caption</label>
      <div class="col-sm-9">
        <input name="title"  id="rf_image_caption" class="form-control  form-control-sm border-orange mt-1" ng-model="addProdReviewsData.image_caption">
      </div>
    </div>
    <div class="form-group row">
      <label for="rf_image_comment" class="col-sm-2 col-form-label text-end">Comment</label>
      <div class="col-sm-9">
        <input name="image_comment"  id="rf_image_comment" class="form-control  form-control-sm border-orange mt-1" ng-model="addProdReviewsData.image_comment">
      </div>
    </div>
  </form>
  <form id="frmProductReviews" enctype="multipart/form-data" method="post">
    <input type="text" id="frmPrId" name="id" value="" hidden=true>
    <input type="text" id="image_ctype" name="ctype" value="Reviews" hidden=true>
    <input type="text" id="lang" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
" hidden=true>
    <input type="text" id="partno" name="partno" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
" hidden=true>

    <p><b>
        <input class="easyui-textbox" name="title" style="width:640px;"
          data-options="label:'Title:',labelWidth:'140px',labelAlign:'right'">
      </b></p>
    <table><tr>
      <td style="width:140px;vertical-align: top;"><b >Short Description:</b></td>
      <td>
        <span style="margin-left:140px;"><textarea class="summernote" name="short_desc" id="pr_shortdesc_id" rows="10" cols="80"></textarea></span>
      </td>
    </tr></table>
    <p>
      <label class="textbox-label textbox-label-before"
        style="text-align: right; width: 140px; height: 20px; line-height: 20px;"><b>Review Type:</b></label>
    </p>
    <div style="margin-bottom:10px">
      <input class="easyui-radiobutton" name="type" value="Award"
        data-options="label:'Award:',labelWidth:'140px',labelAlign:'right'">
      <input class="easyui-radiobutton" name="type" value="Blog"
        data-options="label:'Blog:',labelWidth:'140px',labelAlign:'right'">
      <input class="easyui-radiobutton" name="type" value="Video"
        data-options="label:'Video:',labelWidth:'140px',labelAlign:'right'">
    </div>
    <div style="margin-bottom:10px">
      
    </div>
    <p>
      <input class="easyui-textbox" name="web_link" style="width:640px;"
        data-options="label:'Web link:',labelWidth:'140px',labelAlign:'right'">
    </p>
    <p>
      <input class="easyui-textbox" name="remarks" style="width:640px;"
        data-options="label:'Remarks:',labelWidth:'140px',labelAlign:'right'">
        <br><span style="color:grey;font-size:10px;margin-left:140px;">(e.g. dd-mm-yyyy)</span>
    </p>
    <table style="margin:10px 0px;"><tr>
      <td style="vertical-align: top;">
        <input class="easyui-textbox" name="seqno" style="width:340px;"
        data-options="label:'Seqno:',labelAlign:'right',labelWidth:'140px'"></td>
      <td>
        <input class="easyui-checkbox" name="is_highlight" value="1"
        data-options="label:'Is Large box?:',labelWidth:'140px',labelAlign:'right'">
      </td>
    </tr></table>
    <p><input id="frmProductReviews_status" name="status" type="text"></p>
    <hr>
    <table>
      <tr>
        <td style="vertical-align: top;">
          <div><b>Icon:</b></div>
          <div id="product_review_file">
            <input class="easyui-filebox" name="iconfile" style="width:300px;"
              data-options="prompt:'Choose a file...',label:'Icon File',labelWidth:'80px',labelAlign:'right'">
            <p>
              <img src="" id="productReviewIconSrc" style="display: hidden; margin: auto;">
          </div>
          <div style="margin-bottom:10px">
            <input class="easyui-checkbox" name="is_hide_icon" value="1"
              data-options="label:'Hide Icon?:',labelWidth:'80px',labelAlign:'right'">
          </div>
        </td>
        <td style="vertical-align: top;">
          <div><b>Image:</b></div>
          <div id="product_review_file">
            <input class="easyui-filebox" name="imagefile" style="width:340px;"
              data-options="prompt:'Choose a file...',label:'Image File',labelWidth:'100px',labelAlign:'right'">
            <p>
          </div>
          <p>
            <input class="easyui-textbox" name="caption" style="width:340px;"
              data-options="label:'Caption:',labelWidth:'100px',labelAlign:'right'">
          <p>
            <input class="easyui-textbox" name="comment" style="width:340px;"
              data-options="label:'Comment:',labelWidth:'100px',labelAlign:'right'">
          <p>
            <img src="" id="productReviewImageSrc" style="display: hidden; margin: auto;">
          </td>
      </tr>
    </table>  
  </form>

  <div style="text-align:center;padding:5px 0">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitProductReviewsForm()"
      style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelProductReviewsForm()"
      style="width:80px">Cancel</a>
  </div>
</div>
<!-- End of review Form Dialog -->
<!-- Begin view image dialog-->
<div class="easyui-dialog" id="dlgViewImage" data-options="resizable:true"
  style="width:840px;height:680px;padding:10px 10px" closed="true" title="View Image">
  <img src="" id="viewImageSrc" style="display: block; margin: auto;">
  <embed src="PDF_SOURCE_URL" id="embedPdf" style="display: none;" width="100%" height="600px" />
</div>
<!-- END view image dialog-->

<!-- Begin introduction form-->
<div class="easyui-dialog" id="introformdlg" data-options="resizable:true"
  style="width:840px;height:680px;padding:10px 10px" closed="true" title="Edit Introduction">
  <form id="introform" method="post">
    <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
    <input name="partno" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
    <input id="cc1" name="intro_display_type" class="easyui-combobox" data-options="
        valueField: 'id',
        textField: 'text',
        label:'Display Type:',
        labelPosition:'left',
        labelWidth:'140px',
        width:'100%',
        labelAlign: 'Right',
        url: 'manproducts.php?action=intro_display_options&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
',
        ">
    <textarea class="summernote" name="introduction" id="introduction_id"></textarea>
    </textarea>
  </form>
  <div style=" text-align:center;padding:5px 0">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitIntroForm()" style="width:80px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelIntroForm()" style="width:80px">Cancel</a>
    <div>
    </div>
    <!-- End introduction form-->
    <!-- Begin Add Links form-->
    <div class="easyui-dialog" id="dlgAddLinks" data-options="resizable:true"
      style="width:500px;height:350px;padding:10px 10px" closed="true" title="Add links">
      <form id="addLinksform" method="post">
        <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
        <input name="partno" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['partno']->value;?>
">
        (Add links with comma ",")<br>
        <textarea rows="6" cols="60" name="addLinks" id="addLinks"></textarea>
      </form>
      <div style=" text-align:center;padding:5px 0">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitAddLinksForm()"
          style="width:80px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelAddLinksForm()"
          style="width:80px">Cancel</a>
        <div>
        </div>
        <!-- End Add links form-->

        <!-- Begin description form-->
        <div class="easyui-dialog" id="descformdlg" data-options="resizable:true"
          style="width:840px;height:870px;padding:10px 10px" closed="true" title="Edit Description">
          <form id="descform" method="post">
            <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
            <input name="partno" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
            <b>Long Description:</b><br>
            <textarea class="summernote" name="longdesc" id="longdesc_id" "></textarea>
    <b>Short Description:</b><br>
    <textarea class=" summernote" name="shortdesc" id="shortdesc_id" "></textarea>
  <b>Short Description 1:</b><br>
  <textarea class=" summernote" name="shortdesc1" id="shortdesc1_id" "></textarea>
  <b>Short Description 2:</b><br>
  <textarea class=" summernote" name="shortdesc2" id="shortdesc2_id" "></textarea>
  </textarea>
  </form>
    <div style=" text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitDescForm()" style="width:80px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelDescForm()" style="width:80px">Cancel</a>
    <div>
</div>
<!-- End description form-->
<!-- Begin note form-->
<div class="easyui-dialog" id="noteformdlg" data-options="resizable:true"
style="width:840px;height:450px;padding:10px 10px" closed="true" title="Edit Note">
<form id="noteform" method="post">
  <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
  <input name="partno" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
<b>Note:</b><br>
<textarea class="summernote" name="note" id="note_id" ></textarea>

          </form>
          <div style=" text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitNoteForm()"
              style="width:80px">Save</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelNoteForm()"
              style="width:80px">Cancel</a>
            <div>
            </div>
            <!-- End note form-->

            <!-- Begin Product Spec html form-->
            <div class="easyui-dialog" id="spechtmlformdlg" data-options="resizable:true"
              style="width:840px;height:740px;padding:10px 10px" closed="true" title="Edit Product Spec HTML">
              <form id="spechtmlform" method="post">
                <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
                <input name="partno" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
                <textarea class="summernote" name="html_1" id="spechtml_id" "></textarea>
            </textarea>
          </form>
          <div style=" text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitSpechtmlForm()"
              style="width:80px">Save</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelSpechtmlForm()"
              style="width:80px">Cancel</a>
            <div>
            </div>
            <!-- End Product Spec html form-->
           <!-- Begin Product Spec group form-->
        <div  class="easyui-dialog" id="dlgAddSpecGroup"  data-options="resizable:true" style="width:550px;height:300px;padding:10px 10px" closed="true"  title="Add Spec Group">
          <form id="addSpecGroupForm"  method="post" >
          <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
">
          <input name="partno" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
">
          <input name="lang" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
">

            <p>
              <input class="easyui-textbox" name="group_name_en" style="width:500px;margin-top:30px"
              data-options="label:'Spec Group Name (EN) :',labelWidth:'140px',labelAlign:'right'">
            </p>
            <p>
              <input class="easyui-textbox" name="group_name_cn" style="width:500px;margin-top:30px"
              data-options="label:'Spec Group Name (CN) :',labelWidth:'140px',labelAlign:'right'">
            </p>  
            <p>
              <input class="easyui-textbox" name="seqno" style="width:500px;margin-top:30px"
              data-options="label:'seqno:',labelWidth:'140px',labelAlign:'right'">
            </p>
          </form>
          <div style="text-align:center;padding:5px 0">
              <a href="javascript:void(0)" class="easyui-linkbutton"  onclick="SubmitSpecAddGroupForm()"
              style="width:80px">Save</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelSpecAddGroupForm()"
              style="width:80px">Cancel</a>
            <div>
        </div>
            <!-- End Product Spec group form-->
            <!-- Begin edit Product Spec group form-->
        <div  class="easyui-dialog" id="dlgEditSpecGroup"  data-options="resizable:true" style="width:550px;height:300px;padding:10px 10px" closed="true"  title="Add Spec Group">
          <form id="editSpecGroupForm"  method="post" >
          <input name="id" type="hidden" value="">
          <input name="lang" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
">
          <input class="easyui-textbox" id="editSpecGroupForm_group_name" name="group_name" style="width:500px;margin-top:30px"
                  data-options="label:'Spec Group Name:',labelWidth:'140px',labelAlign:'right'">
                  <input class="easyui-textbox" id="editSpecGroupForm_seqno" name="seqno" style="width:500px;margin-top:30px"
                  data-options="label:'seqno:',labelWidth:'140px',labelAlign:'right'">
          </form>
          <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitSpecEditGroupForm()"
              style="width:80px">Save</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelSpecEditGroupForm()"
              style="width:80px">Cancel</a>
            <div>
        </div>
            <!-- End edit Product Spec group form-->
            <!-------------------------------->

            <!-- Begin of Keywords Form Dialog -->
            <div class="easyui-dialog" id="keywordformdlg" data-options="resizable:true"
              style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">
              <form id="keywordform" method="post">

                <input type="text" id="kdf_id" name="id" hidden=true>
                <input class="easyui-textbox" name="keywords" style="width:550px;height:120px;"
                  data-options="label:'Keywords:',labelPosition:'top',multiline:'true'">
                <p>
                  <input class="easyui-textbox" name="fankeywords" style="width:550px;height:100px;"
                    data-options="label:'Fan Keywords:',labelPosition:'top',multiline:'true'">
                <p>
                  <input class="easyui-textbox" name="extrakeywords" style="width:550px;height:100px;"
                    data-options="label:'Extra Keywords:',labelPosition:'top',multiline:'true'">
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitkeywordform()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelkeywordform()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of Keywords Form Dialog -->


            <!-- Begin of Keywords Form Dialog -->
            <div class="easyui-dialog" id="dlgcheckboxkeywordlist" data-options="resizable:true"
              style="width:650px;height:700px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Add/Edit keywords">
              <form id="keywordlistform" method="post">
                <input type="text" id="keywordlistformUncheck" name="keywordlistformUncheck" hidden=true>
                <table id="keywordlistselection" class="easyui-datagrid" title="Keyword Listing" style="width:550px;height:600px"
                data-options="rownumbers:true,pageSize: 25,view:scrollview,url:'mankeywordlist.php?action=list&status=1',method:'get'">
            <thead>
                <tr>
                    <th data-options="field:'ck',checkbox:true"></th>
                    <th data-options="field:'id',width:40">Item ID</th>
                    <th data-options="field:'name',width:100">Name</th>
                    <th data-options="field:'type',width:150">Type</th>
                    <th data-options="field:'display_name_en',width:200 ">Display Name (EN)</th>
                </tr>
            </thead>
        </table>
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitkeywordlistform()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelkeywordlistform()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of Keywords Form Dialog -->


            <!-- Begin of Main Form Dialog -->
            <div class="easyui-dialog" id="mainformdlg" data-options="resizable:true"
              style="width:630px;height:650px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">
              <form id="mainform" method="post">

                <input type="text" id="mf_id" name="id" hidden=true>
                <input type="text" id="mf_partno" name="partno" hidden=true>
                <input type="text" id="mfv_active" name="active" hidden=true>
                <input type="text" id="mfv_newproduct" name="newproduct" hidden=true>
                <input type="text" id="mfv_iscooler" name="iscooler" hidden=true>
                <input type="text" id="mfv_displaypartnoline" name="displaypartnoline" hidden=true>

                <input class="easyui-textbox" name="title" style="width:500px;"
                  data-options="label:'Title:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="name" style="width:500px;"
                    data-options="label:'Name:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <!-- <input id="mf_prod_cat1" class="easyui-combobox" name="prod_cat1" style="width:500px" data-options="
        url:'getnavmenu.php',
        mode: 'remote',
        method: 'get',
        valueField:'id',
        textField:'name',
        label: 'Product Category:',
        labelPosistion: 'left',
        labelAlign: 'right',
        labelWidth: '140px',
        ">
                  </input> -->
                <p>
                  <input class="easyui-textbox" name="partnoline" style="width:500px;"
                    data-options="label:'Partno Line:',labelWidth:'140px',labelAlign:'right'">
                  <input class="easyui-checkbox" id="mf_displaypartnoline" name="mf_displaypartnoline">
                <p>
                  <input class="easyui-textbox" name="related" style="width:500px;"
                    data-options="label:'Related Products:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="series" style="width:500px;"
                    data-options="label:'Series Name:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="specialtemplate" style="width:500px;"
                    data-options="label:'Special Template:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="detailtoppanel" style="width:500px;"
                    data-options="label:'Top Panel Template:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="detailtoppanelbgl" style="width:500px;"
                    data-options="label:'Top Panel Left Background:',labelWidth:'190px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="detailtoppanelbgr" style="width:500px;"
                    data-options="label:'Top Panel Right Background:',labelWidth:'190px',labelAlign:'right'">
                <p>
                  <input class="easyui-checkbox" id="mf_active" name="mf_active" label="Active Detail Page & Search" labelWidth="75px"
                    labelAlign="left" labelPosition="after">
                  <input class="easyui-checkbox" id="mf_newproduct" name="mf_newproduct" label="New Product"
                    labelWidth="110px" labelAlign="left" labelPosition="after">
                  <input class="easyui-checkbox" id="mf_iscooler" name="mf_iscooler" label="is Cooler" labelWidth="75px"
                    labelAlign="left" labelPosition="after">
                    
                <p>
                  <select class="easyui-combobox" name="plistflag" style="width:500px;" label="Product List Flag:"
                    labelWidth="130px" labelAlign="right">
                    <option value="0">Single Image</option>
                    <option value="1">Single Image With Image</option>
                    <option value="2">Image with Icon Map</option>
                  </select>
                <p>
                  <select class="easyui-combobox" name="pdetailflag" style="width:500px;" label="Product Detail Flag:"
                    labelWidth="150px" labelAlign="right">
                    <option value="0">Single Image</option>
                    <option value="1">Single Image With Image</option>
                    <option value="2">Image with Icon Map</option>
                  </select>
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitMainForm()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelMainForm()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of Main Form Dialog -->

            <?php if ($_smarty_tpl->tpl_vars['record']->value['iscooler'] == '1') {?>
            <?php $_smarty_tpl->_subTemplateRender('file:socketform.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <?php $_smarty_tpl->_subTemplateRender('file:socketform_new.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('newSockets'=>$_smarty_tpl->tpl_vars['newSocketlist']->value), 0, false);
?>
            <?php }?>



            <!-- Begin of Product Review Form Dialog -->
            <div class="easyui-dialog" id="reviewformdlg" data-options="resizable:true"
              style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">
HERE
              <form id="reviewform" method="post">
                <input type="text" id="pr_id" name="id" hidden=true>
                <input type="text" id="pr_partno" name="partno" hidden=true>
                <input type="text" id="pr_lang" name="lang" hidden=true>
                <input class="easyui-textbox" name="seqno" style="width:545px;"
                  data-options="label:'Seqno:',labelAlign:'right',labelWidth:'85px'">
                <p>
                  <input class="easyui-textbox" name="articlelink" style="width:545px;"
                    data-options="label:'Article Link:',labelAlign:'right',labelWidth:'85px'">
                <p>
                  <input class="easyui-textbox" name="summary" style="width:545px;height:90px;"
                    data-options="label:'Summary:',labelWidth:'85px',labelAlign:'right',multiline:'true'">
                <p>
                  <input class="easyui-textbox" name="comment" style="width:545px;height:90px;"
                    data-options="label:'Comment:',labelWidth:'85px',labelAlign:'right',multiline:'true'">
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitReviewForm()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelReviewForm()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of Product Review Form Dialog -->

            <!-- Begin of FAQ Form Dialog -->
            <div class="easyui-dialog" id="faqformdlg" data-options="resizable:true"
              style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">

              <form id="faqform" method="post">

                <input type="text" id="faq_id" name="id" hidden=true>
                <input type="text" id="faq_partno" name="partno" hidden=true>
                <input type="text" id="faq_lang" name="lang" hidden=true>
                <input type="text" id="faq_editmode" name="editmode" hidden=true>

                <!-- <input class="easyui-combobox" style="width:545px;" name="questioncat"
                  data-options="valueField:'id', textField:'text',url:'manprodfaq.php?action=get_questioncat',label:'Category',labelPosition:'top'"> -->
                <input class="easyui-textbox" name="question" style="width:545px;"
                  data-options="label:'Question:',labelAlign:'left',labelWidth:'85px',labelPosition:'top'">
                <input class="easyui-textbox" name="answer" style="width:545px;height:200px;"
                  data-options="label:'Answer:',labelWidth:'85px',labelPosition:'top',labelAlign:'left',multiline:'true'">
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFAQForm()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelFAQForm()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of FAQ Form Dialog -->

            <!-- Begin of Image Form Dialog -->
            <div class="easyui-dialog" id="imageformdlg" data-options="resizable:true"
              style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">
              <form id="imageform" enctype="multipart/form-data" method="post">

                <input type="text" id="imf_id" name="id" hidden=true>
                <input type="text" id="imf_ctype" name="ctype" hidden=true>
                <input type="text" id="imf_lang" name="lang" value=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
 hidden=true>
                <input type="text" id="imf_partno" name="partno" value=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
 hidden=true>

                <div id="imf_file">
                  <input class="easyui-filebox" name="imagefile" style="width:500px;"
                    data-options="prompt:'Choose a file...',label:'Image File',labelWidth:'140px',labelAlign:'right'">
                  <p>
                </div>
                <input class="easyui-textbox" name="seqno" style="width:500px;"
                  data-options="label:'Seqno:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="caption" style="width:500px;"
                    data-options="label:'Caption:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="comment" style="width:500px;"
                    data-options="label:'Comment:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <p><input class="easyui-checkbox" name="listpic" value="1" data-options="label:'List Picture:',labelWidth:'140px',labelAlign:'right'"></p>
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitImageForm()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelImageForm()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of Image Form Dialog -->
            <!-------------------------------->
            <!-- Begin of Download Form Dialog -->
            <div class="easyui-dialog" id="downloadformdlg" data-options="resizable:true"
              style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">
              <form id="downloadform" enctype="multipart/form-data" method="post">

                <input type="text" id="dnf_id" name="id" hidden=true>
                <input type="text" id="dnf_lang" name="lang" value=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
 hidden=true>
                <input type="text" id="dnf_partno" name="partno" value=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
 hidden=true>

                <div id="dnf_file">
                  <input class="easyui-filebox" name="downloadfile" style="width:500px;"
                    data-options="prompt:'Choose a file...',label:'Download File',labelWidth:'140px',labelAlign:'right'">
                  <p>
                </div>
                <div id="dnf_video_link">
                  <p>
                    <input class="easyui-textbox" name="video_link" style="width:500px;"
                      data-options="label:'Video Link:',labelWidth:'140px',labelAlign:'right'">
                  </p>
                </div>
                <select class="easyui-combobox" id="dnf_ftype" name="ftype" style="width:500px;"
                  data-options="label:'File Type:',labelWidth:'140px',labelAlign:'right'">
                  <option value="manual">Manual</option>
                  <option value="software">Software</option>
                  <option value="video_link">Video Link</option>
                </select>
                <p>
                  <input class="easyui-textbox" name="seqno" style="width:500px;"
                    data-options="label:'Seqno:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-datebox" id="dnf_releasedate" name="releasedate" style="width:500px;"
                    data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="subject" style="width:500px;"
                    data-options="label:'Subject:',labelWidth:'140px',labelAlign:'right'">
                <p>
                  <input class="easyui-textbox" name="comment" style="width:500px;"
                    data-options="label:'Comment:',labelWidth:'140px',labelAlign:'right'">
                <p>
              </form>

              <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitDownloadForm()"
                  style="width:80px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelDownloadForm()"
                  style="width:80px">Cancel</a>
              </div>
            </div>
            <!-- End of Download Form Dialog -->
              <!-- Begin edit box form-->
  <div class="easyui-dialog" id="dlgEditBox" data-options="resizable:true"
    style="width:600px;height:400px;padding:10px 10px" closed="true" title="Edit Box Content">
    <form id="frmEditBox" method="POST">
      <input id="frmEditBox_menucat" type="hidden" hidden=true>
      <p><input id="frmEditBox_id" type="text"></p>
      <p><input id="frmEditBox_boxno" type="text"></p>
      <p><input id="frmEditBox_box_name" type="text"></p>
      <p><input id="frmEditBox_status" type="text"></p>
      <p><input id="frmEditBox_seqno" type="text"></p>
    </form>
    <div style=" text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitEditForm()" style="width:80px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelEditForm()" style="width:80px">Cancel</a>
    </div>
  </div>
  <!-- End edit box form-->


  </div>
</body>

            <?php echo '<script'; ?>
>
              function submitFAQForm() {
                $('#faqform').form('submit', {
                  url: 'manprodfaq.php?action=save',
                  success: function (data) {
                    $('#faqformdlg').dialog('close');
                    $("#faqlist").datagrid("reload");
                  }
                });
              }
              function cancelFAQForm() {
                $('#faqform').form('clear');
                $('#faqformdlg').dialog('close');
              }

              var cardview = $.extend({}, $.fn.datagrid.defaults.view, {
                renderRow: function (target, fields, frozen, rowIndex, rowData) {
                  var cc = [];
                  cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
                  if (!frozen && rowData.id) {
                    var img = rowData.sitelogo;
                    cc.push('<img src="/akasa10/img/product/common/review/' + img + '" style="width:150px;float:left">');
                    cc.push('<div style="float:left;margin-left:20px;width:800px;">');
                    for (var i = 2; i < fields.length; i++) {
                      var copts = $(target).datagrid('getColumnOption', fields[i]);
                      cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> ' + rowData[fields[i]] + '<br>');
                    }
                    cc.push('</div>');
                  }
                  cc.push('</td>');
                  return cc.join('');
                }
              });


              var cardview_feature = $.extend({}, $.fn.datagrid.defaults.view, {
                renderRow: function (target, fields, frozen, rowIndex, rowData) {
                  var cc = [];
                  cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
                  if (!frozen && rowData.id) {
                    var img = rowData.docname;
                    cc.push('<img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Features/' + img + '" style="width:150px;float:left">');
                    cc.push('<div style="float:left;margin-left:20px;width:900px;">');
                    for (var i = 1; i < fields.length; i++) {
                      var copts = $(target).datagrid('getColumnOption', fields[i]);
                      cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> ' + rowData[fields[i]] + '<br>');
                    }
                    cc.push('</div>');
                  }
                  cc.push('</td>');
                  return cc.join('');
                }
              });
              // Specification - JM
              var cardview_specImage = $.extend({}, $.fn.datagrid.defaults.view, {
                renderRow: function (target, fields, frozen, rowIndex, rowData) {
                  console.log(rowData);
                  var cc = [];
                  cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
                  if (!frozen && rowData.id) {
                    var img = rowData.docname;
                    cc.push('<img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Specification/' + img + '" style="width:150px;float:left">');
                    cc.push('<div style="font-size:10px;float:left;margin-left:0px;width:900px;">');
                    for (var i = 1; i < fields.length; i++) {
                      var copts = $(target).datagrid('getColumnOption', fields[i]);
                      cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> ' + rowData[fields[i]] + '<br>');
                    }
                    cc.push('</div>');
                  }
                  cc.push('</td>');
                  return cc.join('');
                }
              });

              var cardview_gallery = $.extend({}, $.fn.datagrid.defaults.view, {
                renderRow: function (target, fields, frozen, rowIndex, rowData) {
                  var cc = [];
                  cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
                  if (!frozen && rowData.id) {
                    var img = rowData.docname;
                    cc.push('<img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Gallery/' + img + '" style="width:150px;float:left">');
                    cc.push('<div style="float:left;margin-left:20px;width:900px;">');
                    for (var i = 1; i < fields.length; i++) {
                      var copts = $(target).datagrid('getColumnOption', fields[i]);
                      if (copts.title == 'Listpic') {
                        if (rowData[fields[i]] == 1) {
                          cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> <span style="color:Blue;"><b> &#x2714;</b></span><br>');
                        } else {
                          cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> <span style="color:Red;"><b> &#x292B;</b></span><br>');
                        }
                      } else {
                        cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> ' + rowData[fields[i]] + '<br>');
                      }

                    }
                    cc.push('</div>');
                  }
                  cc.push('</td>');
                  return cc.join('');
                }
              });
              var cardview_content = $.extend({}, $.fn.datagrid.defaults.view, {
                renderRow: function (target, fields, frozen, rowIndex, rowData) {
                  var cc = [];
                  cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
                  if (!frozen && rowData.id) {
                    var img = rowData.docname;
                    cc.push('<img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Contents/' + img + '" style="width:150px;float:left">');
                    cc.push('<div style="float:left;margin-left:20px;width:900px;">');
                    for (var i = 1; i < fields.length; i++) {
                      var copts = $(target).datagrid('getColumnOption', fields[i]);
                      cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> ' + rowData[fields[i]] + '<br>');
                    }
                    cc.push('</div>');
                  }
                  cc.push('</td>');
                  return cc.join('');
                }
              });

              var cardview_movie = $.extend({}, $.fn.datagrid.defaults.view, {
                renderRow: function (target, fields, frozen, rowIndex, rowData) {
                  var cc = [];
                  cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
                  if (!frozen && rowData.id) {
                    var img = rowData.docname;
                    cc.push('<video src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Movies/' + img + '#t=3" type="video/mp4" style="width:150px;float:left"></video>');
                    cc.push('<div style="float:left;margin-left:20px;width:900px;">');
                    for (var i = 1; i < fields.length; i++) {
                      var copts = $(target).datagrid('getColumnOption', fields[i]);
                      cc.push('<span class="c-label"><b>' + copts.title + ':</b></span> ' + rowData[fields[i]] + '<br>');
                    }
                    cc.push('</div>');
                  }
                  cc.push('</td>');
                  return cc.join('');
                }
              });

              $(function () {
                $('#movielist').datagrid({
                  view: cardview_movie
                });
              });

              $(function () {
                $('#featurelist').datagrid({
                  view: cardview_feature
                });
              });

              $(function () {
                $('#gallerylist').datagrid({
                  view: cardview_gallery,
                  idField: 'id',
                  columns: [[
                    { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
                    { field: 'docname', title: 'File Name', width: 150, sortable: true },
                    { field: 'seqno', title: 'Seqno', width: 150 },
                    { field: 'caption', title: 'Caption', width: 150 },
                    { field: 'comment', title: 'Comment', width: 150 },
                    { field: 'listpic', title: 'Listpic', width: 150 },
                  ]]
                });
              });

              $(function () {
                $('#contentlist').datagrid({
                  view: cardview_content
                });
              });

              function showintroduction() {
                var url = "manproducts.php?action=getintroduction&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
";
                $.ajax({
                  url: url,
                  type: "GET",
                  dataType: "json",
                  success: function (data) {
                    $("#p_introduction").panel('refresh');
                  }
                });
              }

              function editintroduction() {

                var url = "manproducts.php?action=getintroduction&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
";
                $.ajax({
                  url: url,
                  type: "GET",
                  dataType: "json",
                  success: function (data) {
                    $("#introduction_id").summernote('reset');
                    $("#introduction_id").summernote('code', data.introduction);
                    // set display type

                  }
                });
                $('#introformdlg').dialog('open');
              }
              function SubmitIntroForm() {
                $('#introform').form('submit', {
                  url: 'manproducts.php?action=saveintroduction',
                  success: function (data) {
                    $('#introformdlg').dialog('close');
                    showintroduction();
                    $('#bteditintroduction-cc1').combobox('reload');
                  }
                });
              }
              function CancelIntroForm() {
                $('#introformdlg').dialog('close');
              }
              //SubmitAddLinksForm
              function SubmitAddLinksForm() {
                $('#addLinksform').form('submit', {
                  url: "manfile_easyui.php?action=addlinks",
                  //  url: 'manproducts.php?action=saveintroduction',
                  success: function (data) {
                    // filelist  reload
                    $("#filelist").datagrid("reload");
                    $('#dlgAddLinks').dialog('close');
                    $('#addLinks').val("");
                  }
                });
              }
              function CancelAddLinksForm() {
                $('#dlgAddLinks').dialog('close');
              }
              function deleteLink(index, webpath) {
                $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
                  if (r) {
                    fd = new FormData();
                    fd.append('removeKey', index);
                    fd.append('webpath', webpath);
                    $.ajax({
                      url: 'manfile_easyui.php?action=removelinks',
                      enctype: 'multipart/form-data',
                      type: 'post',
                      data: fd,
                      async: true,
                      contentType: false,
                      processData: false,
                      dataType: 'json',
                      success: function (response) {
                        $("#filelist").datagrid("reload");
                      }
                    });
                    fd = new FormData();
                  } // end of if confirm
                }); // end of confirm messager
              }

              function editdescription() {
                var url = "manproducts.php?action=getdescription&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
";
                $.ajax({
                  url: url,
                  type: "GET",
                  dataType: "json",
                  success: function (data) {
                    $("#shortdesc_id").summernote('reset');
                    $("#shortdesc_id").summernote('code', data.shortdesc);
                    $("#shortdesc1_id").summernote('reset');
                    $("#shortdesc1_id").summernote('code', data.shortdesc1);
                    $("#shortdesc2_id").summernote('reset');
                    $("#shortdesc2_id").summernote('code', data.shortdesc2);
                    $("#longdesc_id").summernote('reset');
                    $("#longdesc_id").summernote('code', data.longdesc);
                  }
                });
                $('#descformdlg').dialog('open');
              }

              function SubmitDescForm() {
                $('#descform').form('submit', {
                  url: 'manproducts.php?action=savedescription',
                  success: function (data) {
                    $('#descformdlg').dialog('close');
                    $('#p_longdesc').panel('refresh');
                    $('#p_shortdesc').panel('refresh');
                    $('#p_shortdesc1').panel('refresh');
                    $('#p_shortdesc2').panel('refresh');
                  }
                });
              }
              function CancelDescForm() {
                $('#descformdlg').dialog('close');
              }

              function editnote() {
                var url = "manproducts.php?action=getnote&id=<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
";
                $.ajax({
                  url: url,
                  type: "GET",
                  dataType: "json",
                  success: function (data) {
                    $("#note_id").summernote('reset');
                    $("#note_id").summernote('code', data.note);
                  }
                });
                $('#noteformdlg').dialog('open');
              }
              function SubmitNoteForm() {
                $('#noteform').form('submit', {
                  url: 'manproducts.php?action=savenote',
                  success: function (data) {
                    $('#noteformdlg').dialog('close');
                    $('#p_note').panel('refresh');
                  }
                });
              }
              function CancelNoteForm() {
                $('#noteformdlg').dialog('close');
              }
              function openAddGroup() {
                $('#dlgAddSpecGroup').dialog('open');
              }

            <?php echo '</script'; ?>
>

            <?php echo '<script'; ?>
>
              var faqeditmode = '0';
              var partno = '<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
';
              function getRowIndex(target) {
                var tr = $(target).closest('tr.datagrid-row');
                return parseInt(tr.attr('datagrid-row-index'));
              }

              $(function () {
                $('#faqlist').datagrid({
                  title: 'Product FAQ',
                  toolbar: '#faqtoolbar',
                  width: 1390,
                  height: 400,
                  singleSelect: true,
                  pagination: true,
                  pageSize: 10,
                  pageList: [10, 20, 40],
                  idField: 'id',
                  url: 'manprodfaq.php?action=list&productcode=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
                  columns: [[
                    { field: 'id', title: 'ID', width: 40, sortable: true, align: 'center' },
                    { field: 'questioncat', title: 'Category', width: 150, sortable: true, align: 'center' },
                    { field: 'question', title: 'Question', width: 380, sortable: true },
                    { field: 'answer', title: 'Answer', width: 520, sortable: true }
                  ]],
                });
              });

              function editfaq(editmode) {
                if (editmode == '1') {
                  var srow = $("#faqlist").datagrid("getSelected");
                  if (srow == null) {
                    alert("Please Select FAQ Row to Edit!");
                  } else {
                    $.ajax({
                      url: "manprodfaq.php?action=getrow2edit&id=" + srow.id + "&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
                      type: "GET",
                      dataType: "json",
                      success: function (json_data) {
                        $('#faqform').form('load', json_data);
                        $("#faq_editmode").val('1');
                        $('#faqformdlg').dialog('open');
                      }
                    });
                  }
                } else {
                  $("#faq_editmode").val('0');
                  $("#faq_lang").val('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
                  $("#faq_partno").val('<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
                  $('#faqformdlg').dialog('open');
                }
              }

              function delfaq() {
                var srow = $("#faqlist").datagrid("getSelected");
                if (srow == null) {
                  alert("Please Select FAQ Row to Delete!");
                } else {
                  $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
                    if (r) {
                      $.ajax({
                        url: "manprodfaq.php?action=delete&id=" + srow.id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                          $("#faqlist").datagrid("reload");
                        }
                      }); // end of ajax
                    } // end of if confirm
                  }); // end of confirm messager
                }
              }


              function submituploadfile() {
                var node = $("#folderlist").tree("getSelected");
                if (node == null) {
                  alert("Select Folder, Please (請選文件夾)!");
                } else {
                  var uploaddir = node.id;
                  fd.append('uploaddir', uploaddir);
                  fd.append('nfiles', nfiles);
                  fd.append('deletedfile[]', deletedfile);
                  fd.append('partno','<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');

                  nfiles = 0;
                  $.ajax({
                    url: 'manfile_easyui.php?action=uploadfile&webcode=webcode',
                    enctype: 'multipart/form-data',
                    type: 'post',
                    data: fd,
                    async: true,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                      $("#filelist").datagrid("reload");
                    }
                  });
                  fd = new FormData();
                  nfiles = 0;
                  deletedfile = [];
                  //clear the file datagrid rows
                  $('#fileuploadlist').datagrid('loadData', []);
                  $("#filelist").datagrid("reload");
                }
              }
              $('#uploadFile').change(function () {
                nfiles++;
                $('#fileuploadlist').datagrid('appendRow', { itemid: nfiles, filename: this.files[0].name });
                fd.append('file_' + nfiles, this.files[0]);
              });
              function removerow() {
                var selectedrow = $("#fileuploadlist").datagrid("getSelected");
                var rowIndex = $("#fileuploadlist").datagrid("getRowIndex", selectedrow);
                deletedfile.push(selectedrow.itemid);
                $("#fileuploadlist").datagrid("deleteRow", rowIndex);
              }
              function removefile() {
                var selectedrow = $("#filelist").datagrid("getSelected");
                console.log(selectedrow);
                if (selectedrow == null) {
                  alert("Please Select A File!");
                } else {
                  var filename = selectedrow.filename;
                  var ans = confirm('OK to Delete File: ' + filename);
                  if (ans == true) {
                    var dirname = selectedrow.dirname;
                    fd = new FormData();
                    fd.append('dirname', selectedrow.dirname);
                    fd.append('filename', selectedrow.filename);
                    fd.append('partno','<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');


                    $.ajax({
                      url: "manfile_easyui.php?action=removefile&dirname=" + dirname + "&filename=" + filename,
                      type: "POST",
                      data: fd,
                    async: true,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                      success: function (json_data) {
                        $("#filelist").datagrid("reload");
                        $("#gallerylist").datagrid("reload");
                      }
                    });//end of ajax
                  }
                }
              }
              function openAddLinks() {
                $('#dlgAddLinks').dialog('open');
              }
            <?php echo '</script'; ?>
>


            <?php echo '<script'; ?>
>
              function delimage(ctype, typelist) {
                var srow = $(typelist).datagrid("getSelected");
                console.log(srow);
                if (srow == null) {
                  alert("Please Select an Image to Delete!");
                } else {
                  
                  $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
                    if (r) {
                      $.ajax({
                        url: "manimages.php?action=delete&ctype=" + ctype + "&id=" + srow.id +"&docname="+srow.docname+'&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
',
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                          $(typelist).datagrid('reload');
                        }
                      }); //end of ajax
                    } // end of if confirm
                  }); // end of confirm messager
                }
              }
              function editimage(ctype, editmode) {
                $('#imageform').form('clear');
                $('#imf_ctype').val(ctype);
                $('#imf_lang').val('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
                $('#imf_partno').val('<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
                if (editmode == '-1') {
                  $('#imf_id').val(editmode);
                  $('#imf_file').show();
                  $('#imageformdlg').dialog('open');
                } else {
                  switch (ctype) {
                    case 'Features':
                      var selectedrow = $("#featurelist").datagrid("getSelected");
                      break;
                    case 'Gallery':
                      var selectedrow = $("#gallerylist").datagrid("getSelected");
                      break;
                    case 'Contents':
                      var selectedrow = $("#contentlist").datagrid("getSelected");
                      break;
                    case 'Movies':
                      var selectedrow = $("#movielist").datagrid("getSelected");
                      break;
                    case 'Download':
                      var selectedrow = $("#downloadlist").datagrid("getSelected");
                      break;
                    case 'Docs':
                      var selectedrow = $("#doclist").datagrid("getSelected");
                      break;
                    case 'ProductReviews':
                      var selectedrow = $("#productReviewsList").datagrid("getSelected");
                      break;
                    case 'Specification':
                      var selectedrow = $("#specImageList").datagrid("getSelected");
                      break;
                  }
                  if (selectedrow == null) {
                    alert("Please Select Product to Edit!");
                  } else {
                    $('#imf_id').val(selectedrow.id);
                    $.ajax({
                      url: "manimages.php?action=getdata&id=" + selectedrow.id,
                      type: "GET",
                      dataType: "json",
                      success: function (data) {
                        $('#imageform').form('load', data);
                      }
                    });
                    $('#imf_file').hide();
                    $('#imageformdlg').dialog('open');
                  }
                }

              }
              function submitImageForm() {
                $('#imageform').form('submit', {
                  url: 'manimages.php?action=save',
                  success: function (data) {
                    $('#imageformdlg').dialog('close');
                    switch (data) {
                      case 'Features':
                        $("#featurelist").datagrid("reload");
                        break;
                      case 'Gallery':
                        $("#gallerylist").datagrid("reload");
                        break;
                      case 'Contents':
                        $("#contentlist").datagrid("reload");
                        break;
                      case 'Download':
                        $("#downloadlist").datagrid("reload");
                        break;
                      case 'Docs':
                        $("#doclist").datagrid("reload");
                        break;
                      case 'Movies':
                        $("#movielist").datagrid("reload");
                        break;
                      case 'ProductReviews':
                        $("#productReviewsList").datagrid("reload");
                        break;
                      case 'Specification':
                        $("#specImageList").datagrid("reload");
                        break;
                    }
                  }
                });
              }
              function cancelImageForm() {
                $('#imageformdlg').dialog('close');
              }

              function editdownload(editmode) {
                $('#downloadform').form('clear');
                $('#dnf_lang').val('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
                $('#dnf_partno').val('<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
');
                if (editmode == '-1') {
                  $('#dnf_id').val(editmode);
                  $('#dnf_ftype').combobox('setValue', 'manual');
                  $('#dnf_file').show();
                  $('#downloadformdlg').dialog('open');
                } else {
                  var selectedrow = $("#downloadlist").datagrid("getSelected");
                  if (selectedrow == null) {
                    alert("Please Select Item to Edit!");
                  } else {
                    $('#dnf_id').val(selectedrow.id);
                    $.ajax({
                      url: "mandownload.php?action=getdata&id=" + selectedrow.id,
                      type: "GET",
                      dataType: "json",
                      success: function (data) {
                        console.log(data);
                        $('#downloadform').form('load', data);
                      }
                    });
                    $('#dnf_file').hide();
                    $('#downloadformdlg').dialog('open');
                  }
                }

              }
              function deletedownload() {
                var selectedrow = $("#downloadlist").datagrid("getSelected");
                if (selectedrow == null) {
                  alert("Please Select item to Delete!");
                } else {
                  if (confirm('OK to Delete file?')) {
                    $.ajax({
                      url: "mandownload.php?action=delete&id=" + selectedrow.id,
                      type: "GET",
                      dataType: "json",
                      success: function (data) {
                        $("#downloadlist").datagrid("reload");
                      }
                    });
                  }
                }
              }
              function submitDownloadForm() {
                //var id = $("#dnf_id").val();
                //alert(id);
                $('#downloadform').form('submit', {
                  url: 'mandownload.php?action=save',
                  success: function (data) {
                    $('#downloadformdlg').dialog('close');
                    $("#downloadlist").datagrid("reload");
                  }
                });
              }
              function cancelDownloadForm() {
                $('#downloadformdlg').dialog('close');
              }
              $(function () {
                $('#downloadlist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Download/' + row.docname);
                  }
                });
              });
              $(function () {
                $('#featurelist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Features/' + row.docname);
                    // $("#viewImageSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Features/' + row.docname);
                    // $("#viewImageSrc").show();
                    // $('#dlgViewImage').dialog('open');
                    //  OpenInNewTab('/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Features/'+row.docname);
                  }
                });
              });
              $(function () {
                $('#gallerylist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Gallery/' + row.docname);
                  }
                });
              });
              $(function () {
                $('#contentlist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Contents/' + row.docname);
                  }
                });
              });
              $(function () {
                $('#movielist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Movies/' + row.docname);
                  }
                });
              });
              function previewFileInDlg(filename, source) {
                const aryDocs = ['pdf', "PDF"];
                // check extension
                let fileExtension;
                fileExtension = filename.substr((filename.lastIndexOf('.') + 1));

                if (jQuery.inArray(fileExtension, aryDocs) !== -1) {
                  console.log(fileExtension);
                  $("#embedPdf").attr("src", source);
                  $("#embedPdf").show();
                  $("#viewImageSrc").hide();
                } else {
                  $("#viewImageSrc").attr("src", source);
                  $("#viewImageSrc").show();
                  $("#embedPdf").hide();
                }
                $('#dlgViewImage').dialog('open');
              }
              function changeKeywordlistType() {

              }
              //keywordlistselection
              $(function () {
                $('#keywordlistselection').datagrid({
                  onCheck: function (index, row) {
                    console.log("onCheck");
                    console.log(row);
                  },
                  onUncheck: function (index, row) {
                    console.log("onUncheck");
                    console.log(row);
                    // update keywordlistformUncheck
                  },
                  onLoadSuccess: function (data) {
                    // get existing keywords id
                    $.ajax({
                      url: "mankeywordlist.php?action=getprodkeyword&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
",
                      enctype: 'multipart/form-data',
                      type: 'get',
                      async: true,
                      contentType: false,
                      processData: false,
                      dataType: 'json',
                      success: function (resp) {
                        if (resp) {
                          //var keys = jQuery.parseJSON(resp);
                          // console.log(keys);
                          for (i = 0; i < data.rows.length; ++i) {
                            if (jQuery.inArray(data.rows[i]['id'], resp) !== -1) {
                              $('#keywordlistselection').datagrid('checkRow', i);
                            }
                          }
                        }
                        //if (jQuery.inArray(fileExtension, aryDocs) !== -1) {
                      }
                    });
                  }
                });
              });
            <?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
