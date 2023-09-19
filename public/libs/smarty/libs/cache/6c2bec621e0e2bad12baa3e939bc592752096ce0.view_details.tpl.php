<?php
/* Smarty version 3.1.34-dev-7, created on 2023-09-13 15:15:48
  from '/akasa/www/marketing/templates/products/view_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6501d2248ad1c4_28265484',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '335d16d23d518cd90e04a34e8e0dcf9ab90e0e28' => 
    array (
      0 => '/akasa/www/marketing/templates/products/view_details.tpl',
      1 => 1693323396,
      2 => 'file',
    ),
    'd085ce64a16ab2a068f2f341fd35f9eab62baf99' => 
    array (
      0 => '/akasa/www/marketing/templates/layout/header.tpl',
      1 => 1686583452,
      2 => 'file',
    ),
    '2bff72c7caf71f01be4f7e23fec52c50bff2254e' => 
    array (
      0 => '/akasa/www/marketing/templates/layout/navmenu.tpl',
      1 => 1682700276,
      2 => 'file',
    ),
    '6c95f2c0794bbb00c8900e7db01e5f1966670ed6' => 
    array (
      0 => '/akasa/www/marketing/templates/products/mainInfo.tpl',
      1 => 1684486954,
      2 => 'file',
    ),
    '46c56503c08b0ede6919a852f1b2da32c5146edb' => 
    array (
      0 => '/akasa/www/marketing/templates/products/overview.tpl',
      1 => 1683706433,
      2 => 'file',
    ),
    'b8dc96dbe0b97468a7c4af3b23d1e7ee3a118022' => 
    array (
      0 => '/akasa/www/marketing/templates/products/product_spec.tpl',
      1 => 1694618144,
      2 => 'file',
    ),
    'f1755732f3cf67057dc7c19e5df68ca81d65c120' => 
    array (
      0 => '/akasa/www/marketing/templates/products/product_reviews.tpl',
      1 => 1690271282,
      2 => 'file',
    ),
    '24ca94beff81ee2d96c6b7066a27b2115b2de0c7' => 
    array (
      0 => '/akasa/www/marketing/templates/products/upload_files.tpl',
      1 => 1692804896,
      2 => 'file',
    ),
    '9ad645fd55671dd2bc63ad932c88b6a845b4422b' => 
    array (
      0 => '/akasa/www/marketing/templates/layout/footer.tpl',
      1 => 1671641732,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 3600,
),true)) {
function content_6501d2248ad1c4_28265484 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html ng-app="akasa-web">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script language="JavaScript" src="/marketing/libs/easyui/jquery.min.js"></script>
  <script type="text/javascript" src="/marketing/libs/easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="/marketing/libs/easyui/extension/datagrid-dnd.js"></script>
  <script type="text/javascript" src="/marketing/libs/easyui/locale/easyui-lang-en.js"></script>
  <script type="text/javascript" src="/marketing/libs/easyui/extension/datagrid-scrollview.js"></script>
  <script type="text/javascript" src="/marketing/libs/easyui/extension/datagrid-groupview.js"></script>
  <script type="text/javascript" src="/marketing/libs/summernote/summernote-lite.min.js"></script>
  <script type="text/javascript" src="/marketing/libs/summernote/lang/summernote-zh-TW.min.js"></script>
  <script type="text/javascript" src="/marketing/libs/summernote/summernote-image-attributes.js?v=1"></script>
  <script type="text/javascript" src="/marketing/libs/summernote/summernote-image-attributes-en-us.js"></script>
  <script type="text/javascript" src="/marketing/js/const.js?v=10"></script>
  <link rel="stylesheet" type="text/css" href="/marketing/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="/marketing/libs/easyui/themes/metro-orange/easyui.css">
  <link rel="stylesheet" type="text/css" href="/marketing/libs/easyui/themes/icon.css">
  <link rel="stylesheet" type="text/css" href="/marketing/css/common.css?v=1">


  <link rel="stylesheet" type="text/css" href="/marketing/libs/summernote/summernote-lite.min.css">
  <title>BACKEND | </title>
</head><script type="text/javascript" src="/marketing/libs/angularJs-1.8.2/angular.min.js"></script>
<script type="text/javascript" src="/marketing/libs/angularJs-1.8.2/angular-route.min.js"></script>
<script type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/app.js"></script>

<script type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/factory/dataFactory.js"></script>
<script type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/ctrl/ProductDetailCtrl.js"></script>
<script type="text/javascript" src="/marketing/libs/angularJs-1.8.2/src/service/fileService.js"></script>
<script>
 var _config = {
      partno: 'A-ATN01-BK',
      id: '3522',
      lang:getSessionLang(),
      aryFileTypes:'[{"id":0,"text":"blog"},{"id":1,"text":"product"},{"id":2,"text":"gallery"},{"id":3,"text":"feature"},{"id":4,"text":"content"},{"id":5,"text":"manual"},{"id":6,"text":"filter"},{"id":7,"text":"search"},{"id":8,"text":"navimenu"},{"id":9,"text":"list"},{"id":10,"text":"Reviews"},{"id":11,"text":"software"},{"id":12,"text":"layout"},{"id":13,"text":"reviewsitelogo"},{"id":14,"text":"reviewsite"}]'
  };
  var fd = new FormData();
  var nfiles = 0;
  var deletedfile = [];
  var sockets = [];

  var notefd = new FormData();
  var notenfiles = 0;
  var notedeletedfile = [];
  var selected_folder = '';
  var webcode = 'A-ATN01-BK';


  var lang = getSessionLang();

  $(document).ready(function () {
    //  dispheader();
    dispmainform();
    $('#p_introduction').panel({
      href: 'manproducts.php?action=showintroduction&id=3522',
    });
    $('#p_longdesc').panel({
      href: 'manproducts.php?action=showlongdesc&id=3522',
    });
    $('#p_shortdesc').panel({
      href: 'manproducts.php?action=showshortdesc&id=3522',
    });
    $('#p_shortdesc1').panel({
      href: 'manproducts.php?action=showshortdesc1&id=3522',
    });
    $('#p_shortdesc2').panel({
      href: 'manproducts.php?action=showshortdesc2&id=3522',
    });
    $('#p_note').panel({
      href: 'manproducts.php?action=shownote&id=3522',
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
      var parent = "/akasa/www/docs/products/A-ATN01-BK/";
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
      url: "manproducts.php?action=gethddisplay&id=3522&lang=en",
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
          var path = '/docs/products/A-ATN01-BK/Web_Library/Gallery/';
          $("#listpic").attr("src", path + data.listpic.docname);
        }
      }
    });
  }
  function editkeyword() {
    $.ajax({
      url: "manproducts.php?action=getkeyword&id=3522&lang=en",
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
    fd.append('partno', 'A-ATN01-BK');
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
      url: "manproducts.php?action=getmainform&id=3522&lang=en",
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
      url: "exportproduct_detail.php?partno=A-ATN01-BK&lang=en",
      type: "GET",
      dataType: "json",
      success: function (data) {
        //       OpenInNewTab('/akasa10/search.php?seed=A-ATN01-BK');
        alert("Success: upload to akasa10 web!");
      }
    });

  }
  function copyProduct() {
    $('#frmCopyProduct_old_partno').textbox('setValue', 'A-ATN01-BK');

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
    $('#frmCopyProduct_lang').val('en');
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
    fd.append('partno', 'A-ATN01-BK');
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

</script>
<body>
  <nav class="navbar navbar navbar-default navbar-fixed-top navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="mandashboard.php?action=view"><img src="images/akasa_logo.png" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item me-2">
          <a class="nav-link" href="manproducts.php?action=viewlist&webmenu=new"><i class="bi bi-fan"></i>&nbsp;Products</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manemail_contactus.php?action=list"><i class="bi bi-envelope"></i>&nbsp;Email From Web</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="../backend/index.php/en/customer_services/view/list"><i class="bi bi-envelope"></i>&nbsp;Enquires</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="mankeywordlist.php?action=view"><i class="bi bi-filter"></i>&nbsp;Filter</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="mannavmenu.php?action=viewlist"><i class="bi bi-menu-app"></i>&nbsp;Navmenu</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manblogs.php?action=viewlist"><i class="bi bi-collection"></i>&nbsp;Blog</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manupload_files.php?action=viewlist"><i class="bi bi-file-arrow-up"></i>&nbsp;Upload list</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manWebTraffic.php?action=viewlist"><i class="bi bi-file-arrow-up"></i>&nbsp;Web Traffic list</a>
        </li>
        
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-file-arrow-down"></i>&nbsp;Export File
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="exportAllMenucat()">
              [akasa2206] Export All Lists 
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportalldetail()">
              [akasa2206] Export All Product Details 
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportLegacyProduct()">
              [akasa2206] Export Legacy Product 
            </a></li>
      
            <li><a class="dropdown-item" href="#" onclick="createkeyword2206()">
              [akasa2206] Create keywords
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportprodlist2206()">
              [akasa2206] Export Search Product list 
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportindex2206()">
              [akasa2206] Export Search Index 
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportsearchlist2206()">
              [akasa2206] Export Search List 
            </a></li>
          </ul>
        </li>

       <!--
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      -->
      </ul>
      <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar7">
        <ul class="navbar-nav ms-auto flex-nowrap">
          <div class="navbar-collapse collapse" id="collapseNavbar">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="" data-bs-target="#myModal" data-bs-toggle="modal"><i class="bi bi-translate"></i>&nbsp; </a>
              </li>
            </ul>
          </div>
          <li class="nav-item">
            <select class="form-select" id="main_lang" style="width: 120px;" onchange="changeLang(this)">
              <option value="en">English</option>
                  <option value="de">German</option>
                  <option value="fr">French</option>
                  <option value="es">Spanish</option>
                  <option value="pt">Portugese</option>
                  <option value="cn">Chinese</option>
                  <option value="jp">Japanese</option>
            </select>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="bi bi-lightbulb-off"></i>&nbsp;Logout</a>
          </li>

        </ul>
      </div>
    </div>
    </div>
  </div>
</nav>
<script>
  function changeLang(record){
          setSessionLang(record.value);
          getListProduct();
          reloadBoxes(); // function to reload #boxes
          reloadBoxesGrid();
          setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
  }

</script>  <div class="container-fluid" ng-controller="ProductDetailCtrl">
    <div class="row">
      <div class="col h5">
        Product: A-ATN01-BK &nbsp;
        <a href="javascript:void(0)" class="btn btn-sm btn-primary" iconCls="icon-box-arrow-left" plain="true"
          onclick="export2oldweb()"><i class="bi bi-file-arrow-down"></i>&nbsp;Export to akasa10 WebPage</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="export2206web()"><i
            class="bi bi-file-arrow-down"></i>&nbsp;Export to akasa2206 WebPage</a>
        <a href="../akasa2206/update.php?tpl=product/product.detail.tpl&&model=A-ATN01-BK"
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
          
        
<div title='Main Info'>
  <a href="javascript:void(0)" style="margin:5px;" class="btn btn-sm btn-orange" ng-click="editMain(3522)"><i class="bi bi-pencil-fill"></i>&nbsp;Edit Main Info</a>
    <div class="row">
    <div class="col-2">
      <img src="/docs/products/A-ATN01-BK/Web_Library/Gallery/" class="img-thumbnail" >
      <category-directive></category-directive>
    </div>
    <div class="col-6">
      <main-info-directive></main-info-directive>
    </div>
  </div>
  
<!-- Begin of Main Form Modal -->
<div class="modal fade" id="mainFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Main Information</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <!-- start form -->
      <div class="mb-3 row">
        <label for="mf_name" class="col-sm-2 col-form-label col-form-label-sm text-end">Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control form-control-sm" id="mf_name" ng-model="productDetails.name">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="mf_title" class="col-sm-2 col-form-label text-end">Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control form-control-sm" id="mf_title" ng-model="productDetails.title">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="mf_related" class="col-sm-2 col-form-label text-end">Related Products</label>
        <div class="col-sm-10">
          <input type="text" class="form-control form-control-sm" id="mf_related" ng-model="productDetails.related">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">Long Description</label>
        <div class="col-sm-10">
          <textarea class="form-control form-control-sm" id="mf_longDesc" rows="8" ng-model="productDetails.longdesc"></textarea>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">&nbsp;</label>
        <div class="col-sm-10">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="mf_active" ng-model="productDetails.active">
            <label class="form-check-label" for="inlineCheckbox1">Active Detail Page & Search</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="mf_newproduct" ng-model="productDetails.newproduct">
            <label class="form-check-label" for="inlineCheckbox2">New Product</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="mf_iscooler" ng-model="productDetails.iscooler">
            <label class="form-check-label" for="inlineCheckbox3">is Cooler</label>
          </div>
        </div>
      </div>
      <div class="mb-3 row"><!-- pstatus-->
        <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">Product Status</label>
        <div class="col-sm-10">
          <select id="mf_pstatus" name="pstatus" class="form-select form-select-sm" ng-model="productDetails.pstatus" ng-change="changeProductStatus()">
            <option ng-repeat="psOpt in pstatusOpts" ng-value="{#psOpt.value#}">{#psOpt.name#}</option>
          </select>
        </div>
      
    </div>
      <div class="mb-3 row">
        <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">Keywords</label>
        <div class="col-sm-10">
          <textarea class="form-control form-control-sm" id="mf_keywords" rows="3" ng-model="productDetails.keywords"></textarea>
        </div>
      </div>
      <!-- end form --> 
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" ng-click="updateProductDetails()">Save changes</button>
    </div>
  </div>
</div>
</div>
<!-- END of Main Form Modal -->

<!-- Begin of socket Form Modal -->
<div class="modal fade" id="socketTypeFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Socket</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <!-- start form -->
      <h5><span class="badge bg-success">Intel</span></h5>
      <div class="mb-3">
                          <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1700" value="s1700" ng-model="socketTypeList.s1700" >
            <label class="form-check-label" for="st_s1700">LGA1700</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1200" value="s1200" ng-model="socketTypeList.s1200" >
            <label class="form-check-label" for="st_s1200">LGA1200</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1156" value="s1156" ng-model="socketTypeList.s1156" >
            <label class="form-check-label" for="st_s1156">LGA1156</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1155" value="s1155" ng-model="socketTypeList.s1155" >
            <label class="form-check-label" for="st_s1155">LGA1155</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1151" value="s1151" ng-model="socketTypeList.s1151" >
            <label class="form-check-label" for="st_s1151">LGA1151</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1150" value="s1150" ng-model="socketTypeList.s1150" >
            <label class="form-check-label" for="st_s1150">LGA1150</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s2066" value="s2066" ng-model="socketTypeList.s2066" >
            <label class="form-check-label" for="st_s2066">LGA2066</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s2011" value="s2011" ng-model="socketTypeList.s2011" >
            <label class="form-check-label" for="st_s2011">LGA2011</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1366" value="s1366" ng-model="socketTypeList.s1366" >
            <label class="form-check-label" for="st_s1366">LGA1366</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1356" value="s1356" ng-model="socketTypeList.s1356" >
            <label class="form-check-label" for="st_s1356">LGA1356</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s775" value="s775" ng-model="socketTypeList.s775" >
            <label class="form-check-label" for="st_s775">LGA775</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s771" value="s771" ng-model="socketTypeList.s771" >
            <label class="form-check-label" for="st_s771">LGA771</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s3647n" value="s3647n" ng-model="socketTypeList.s3647n" >
            <label class="form-check-label" for="st_s3647n">LGA3647 Narrow</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s3647s" value="s3647s" ng-model="socketTypeList.s3647s" >
            <label class="form-check-label" for="st_s3647s">LGA3647 Square</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s478" value="s478" ng-model="socketTypeList.s478" >
            <label class="form-check-label" for="st_s478">Socket 478</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s604" value="s604" ng-model="socketTypeList.s604" >
            <label class="form-check-label" for="st_s604">Socket 604</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s603" value="s603" ng-model="socketTypeList.s603" >
            <label class="form-check-label" for="st_s603">Socket 603</label>
          </div>
                            <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s370" value="s370" ng-model="socketTypeList.s370" >
            <label class="form-check-label" for="st_s370">Socket 370</label>
          </div>
                </div>
      <h5><span class="badge bg-info">AMD</span></h5>
      <div class="mb-3">
                  <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sam5" value="sam5" ng-model="socketTypeList.sam5" >
            <label class="form-check-label" for="st_sam5">Socket AM5</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sam4" value="sam4" ng-model="socketTypeList.sam4" >
            <label class="form-check-label" for="st_sam4">Socket AM4</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sam3plus" value="sam3plus" ng-model="socketTypeList.sam3plus" >
            <label class="form-check-label" for="st_sam3plus">Socket AM3+</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sam3" value="sam3" ng-model="socketTypeList.sam3" >
            <label class="form-check-label" for="st_sam3">Socket AM3</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sam2plus" value="sam2plus" ng-model="socketTypeList.sam2plus" >
            <label class="form-check-label" for="st_sam2plus">Socket AM2+</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sam2" value="sam2" ng-model="socketTypeList.sam2" >
            <label class="form-check-label" for="st_sam2">Socket AM2</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sfm2plus" value="sfm2plus" ng-model="socketTypeList.sfm2plus" >
            <label class="form-check-label" for="st_sfm2plus">Socket FM2+</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sfm2" value="sfm2" ng-model="socketTypeList.sfm2" >
            <label class="form-check-label" for="st_sfm2">Socket FM2</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sfm1" value="sfm1" ng-model="socketTypeList.sfm1" >
            <label class="form-check-label" for="st_sfm1">Socket FM1</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sa" value="sa" ng-model="socketTypeList.sa" >
            <label class="form-check-label" for="st_sa">Socket A</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s940" value="s940" ng-model="socketTypeList.s940" >
            <label class="form-check-label" for="st_s940">Socket 940</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s939" value="s939" ng-model="socketTypeList.s939" >
            <label class="form-check-label" for="st_s939">Socket 939</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s754" value="s754" ng-model="socketTypeList.s754" >
            <label class="form-check-label" for="st_s754">Socket 754</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1207" value="s1207" ng-model="socketTypeList.s1207" >
            <label class="form-check-label" for="st_s1207">Socket 1207  </label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sg34" value="sg34" ng-model="socketTypeList.sg34" >
            <label class="form-check-label" for="st_sg34">Socket G34</label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_sfs1b" value="sfs1b" ng-model="socketTypeList.sfs1b" >
            <label class="form-check-label" for="st_sfs1b">Socket FS1b  </label>
          </div>
                    <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_s1207f" value="s1207f" ng-model="socketTypeList.s1207f" >
            <label class="form-check-label" for="st_s1207f">1207(F)</label>
          </div>
                </div>
      <!-- end form --> 
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary"  ng-click="updateSocketType('{| $product->partno |}')">Save changes</button>
    </div>
  </div>
</div>
</div>
<!-- END of Main Form Modal -->  
</div>
        
<div title='Overview'>
  
<overview-content-directive intro_display_type="{#productDetails.intro_display_type#}"></overview-content-directive>
<!-- Begin of Main Form Modal -->
<div class="modal fade" id="introFormModal" tabindex="-1" aria-labelledby="introFormModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Introduction</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <!-- start form -->
      <div class="row">
        <div class="col">
          <label for="ovfm_display_type" class="form-label">Display Type</label>
          <select id="ovfm_display_type" class="form-select form-select-sm" aria-label="Display Type" ng-model="productDetails.intro_display_type">
            <option ng-repeat="dType in displayTypes" ng-value="{#dType.value#}">{#dType.name#}</option>
        </select>
      </div>
    </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="ovfm_intro" class="form-label">Introduction</label>
          <textarea class="form-control form-control-sm" id="ovfm_intro" rows="8" ng-model="productDetails.introduction"></textarea>
        </div>
      </div>
      <!-- end form --> 
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" ng-click="updateIntro()">Save changes</button>
    </div>
  </div>
</div>
</div>
<!-- END of Main Form Modal -->

</div>
         <!-- old introduction tab 
          <div title="Introduction" data-options="iconCls:'icon-chat-right-text'">
            <a href="javascript:void(0)" id="bteditintroduction" class="easyui-linkbutton" iconCls="icon-pencil"
              plain="true" onclick="editintroduction()">Edit Introduction</a>
            <div style="width:800px;"><input id="bteditintroduction-cc1" name="intro_display_type"
                class="easyui-combobox" data-options="valueField: 'id',textField: 'text',label:'Display Type:',labelPosition:'left',labelWidth:'140px',width:'100%',disabled: true,labelAlign:'right',
          url: 'manproducts.php?action=intro_display_options&id=3522',
          "></div>
            <div id="p_introduction" class="easyui-panel" style="width:800px;height:650px;">
            </div>
          </div>
        -->

          <!-- product_spec.tpl-->
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

<script>
  var selectedGroup = '';
  var speditmode = '0';
  // start document ready
  $(function () {
    $('#divContentList').hide();
    $('#divSpecHtml').hide();
    $('#divSpecList').show();
//     $('#specList').datagrid({
//       title: 'Product Specification',
//       toolbar: '#spectoolbar',
//       width: 1200,
//       height: 650,
//       singleSelect: true,
//       pagination: true,
//       pageSize: 20,
//       pageList: [20, 40],
//       idField: 'id',
//       //list_group
//       url: "manprodspec.php?action=list_group",
//       //url: backendApi + "/spec/child/list",
//       queryParams: {
//         partno: 'A-ATN01-BK',
//         group_id: 'all',
//         lang: 'en'
//       },
//       columns: [[
//         { field: 'id', title: 'ID', width: 60, sortable: true, align: 'center' },
//         { field: 'seqno', title: 'Seqno', width: 70, sortable: true, align: 'center', editor: 'textbox' },
//         {
//           field: 'group_id', title: 'Group', width: 200, sortable: true, editor: 'textbox',
//           formatter: function (value, row) {
//             // for (var i = 0; i <products.length; i ++) {
//             // 	if (products [i] .productid == value) return products [i] .name;
//             // }
//             if (row.group_id == 0) {
//               return 'All';
//             } else {
//               return row.group_name;
//             }
//           },
//           editor: {
//             type: 'combobox',
//             options: {
//               valueField: 'group_id',
//               textField: 'group_name',
//               method: "GET",
//               url: "manprodspec.php?action=active_spec_group_list&lang=en",
//               required: false
//             }
//           }
//         },
//         { field: 'specname', title: 'Name', width: 200, sortable: true, editor: 'textbox' },
//         { field: 'specdesc', title: 'Content', width: 380, sortable: true, editor:{type:'textbox',options:{height:200,multiline:true}}},
//         { field: 'is_highlight', title: 'Highlight', width: 80, editor: 'textbox',
//           formatter: function (value, row, index) {
// console.log(value);
// console.log(row);
// console.log(index);
//           },
// },
//         {
//           field: 'action', title: 'Action', width: 70, align: 'center',
//           formatter: function (value, row, index) {
//             if (row.editing) {
//               var s = '<a href="javascript:void(0)" onclick="spsaverow(this)"><img src="/easyui/themes/icons/ok.png"></a> ';
//               var c = '<a href="javascript:void(0)" onclick="spcancelrow(this)"><img src="/easyui/themes/icons/cancel.png"></a>';
//               return s + '&nbsp;' + c;
//             } else {
//               var e = '<a href="javascript:void(0)" onclick="speditrow(this)"><img src="/easyui/themes/icons/pencil.png"></a> ';
//               //            var d = '<a href="javascript:void(0)" onclick="spdeleterow(this)">Delete</a>';
//               return e;
//             }
//           }
//         }
//       ]],
//       onBeforeEdit: function (idx, row) {
//         if (!row.group_id) {
//           row.group_id = 1;
//           row.group_name = "General Information";
//         }
//         row.editing = true;
//         $(this).datagrid('refreshRow', idx);
//       },
//       onAfterEdit: function (index, row) {
//         row.editing = false;
//         $('#LHS_menu').tree('reload');
//         $(this).datagrid('refreshRow', index);
//       },
//       onCancelEdit: function (index, row) {
//         row.editing = false;
//         $(this).datagrid('refreshRow', index);
//       },
//       onEndEdit: function (index, row, changes) {
//         $.post('manprodspec.php?action=save', { partno: partno, editmode: speditmode, lang: lang, items: row },
//           function (r) {
//             $('#LHS_menu').tree('reload');
//             $("#specList").datagrid("reload");
//           }
//         );
//         speditmode = '0';
//       }
//     });
    // call tree
    // tree
    $('#spec_group_list').tree({
      method: "GET",
      url: "manprodspec.php?action=spec_group_list&lang=en",
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
      url: "manprodspec.php?action=LHS_menu&partno=A-ATN01-BK&lang=en",
      //url: backendApi + "/spec/lhs_tree/A-ATN01-BK",
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
            var url = 'manimages.php?action=list&partno=A-ATN01-BK&imgtype=Specification&lang=en';
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
                $("#viewImageSrc").attr("src", '/docs/products/A-ATN01-BK/Web_Library/Specification/' + row.docname);
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
                partno: 'A-ATN01-BK',
                group_id: node.id,
                lang: 'en'
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
        $("#viewImageSrc").attr("src", '/docs/products/A-ATN01-BK/Web_Library/Specification/' + row.docname);
        $('#dlgViewImage').dialog('open');
      }
    });

    var url = 'manimages.php?action=list&partno=A-ATN01-BK&imgtype=Specification&lang=en';
    $("#specImageList").datagrid({ url: url });

    $('#p_spechtml').panel({
      href: 'manprodspec.php?action=showspechtml&id=3522',
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
      //url: "manprodspec.php?action=add_new_group",
      url:backendApi+'/spec/group/add',
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
      fd.append('lang', 'en');
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
          url: "manprodspec.php?action=inactive_group&group_id=" + id + "&lang=en",
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
          url: "manprodspec.php?action=active_group&group_id=" + id + "&lang=en",
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
    var url = "manprodspec.php?action=getspechtml&id=3522";
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

  function changeSpecHightlight(id,val){
      $.post('manprodspec.php?action=update_is_highlight', {'id':id, 'is_highlight':val}, function(resp){
        console.log("success");
        console.log(resp);
        if (resp){
          $('#specList').datagrid('reload');
        } else {
          alert(" failed to update ");
        }
      //  $("#mypar").html(response.amount);
      });
  }

</script>          <div title="Reviews" data-options="iconCls:'icon-hand-thumbs-up'">
  <div title="Product Reviews" data-options="iconCls:'icon-image'">
    <div style="width:300px;height:800px;float:left;">
      <reviewsites-directive></reviewsites-directive>
    </div>
    <div style="width:530px;height:800px;float:left;">
      <prod-reviews-directive></prod-reviews-directive>
    </div>

  </div>
  <product-reviews-directive></product-reviews-directive>
</div>

<script>
  // $(function () {

  // });

  // function openProductReviewsForm() {
  //   $('#frmProductReviews').form('clear');
  //   var data = {
  //     'ctype': 'Reviews',
  //     'lang': "en",
  //     'partno': "A-ATN01-BK",
  //   }
  //   $('#frmProductReviews').form('load', data);
  //   $("#productReviewImageSrc").css("display", "none");
  //   $("#productReviewIconSrc").css("display", "none");
  //   $('#product_review_file').show();
  //   $("#pr_shortdesc_id").summernote('reset');
  //   $('#frmPrId').val("");
  //   $("#pr_shortdesc_id").summernote({ 'height': 300 });
  //   $('#frmProductReviews_status').combobox({
  //     width: 340,
  //     data: [{
  //       text: 'Active',
  //       id: '1',
  //       selected: true
  //     }, {
  //       text: 'Inactive',
  //       id: '0'
  //     }],
  //     valueField: 'id', textField: 'text', label: 'Show Status :', labelWidth: '140px', labelAlign: 'right'
  //   });
  //   $('#frmProductReviews_icons').combobox({
  //     width: 340,
  //     //var productWithImgUrl = backendApi + "/product/images_list";
  //     url: backendApi + "/reviewsites/list",
  //     valueField: 'id', textField: 'sitename', label: 'Comp. Icon :', labelWidth: '80px', labelAlign: 'right'
  //   });

  //   $('#dlgProductReviews').dialog('open');
  // }

  // function cancelProductReviewsForm() {
  //   $('#dlgProductReviews').dialog('close');
  // }

  // function submitProductReviewsForm() {
  //   $('#frmProductReviews').form('submit', {
  //     url: 'man_product_reviews.php?action=save',
  //     success: function (data) {
  //       $("#productReviewsList").datagrid("reload");
  //       $('#dlgProductReviews').dialog('close');
  //     }
  //   });
  // }
  // function editProductReviewsForm() {
  //   var selectedrow = $("#productReviewsList").datagrid("getSelected");
  //   if (!selectedrow) {
  //     alert("Please select one of review to Edit.");
  //   }

  //   //$('#frmProductReviews').form('load', "man_product_reviews.php?action=getdata&id="+selectedrow.id);
  //   $.ajax({
  //     url: "man_product_reviews.php?action=getdata&lang=en&id=" + selectedrow.id,
  //     type: "GET",
  //     dataType: "json",
  //     success: function (data) {
  //       console.log(data);
  //       $('#frmProductReviews').form('load', data);
  //       $("#pr_shortdesc_id").summernote('reset');
  //       $("#pr_shortdesc_id").summernote('code', data.short_desc);
  //       // set preview image
  //       if (data.docname) {
  //         $("#productReviewImageSrc").attr("src", '/docs/products/A-ATN01-BK/Web_Library/Reviews/' + data.docname);
  //         $("#productReviewImageSrc").css("display", "block");
  //       }
  //       if (data.icondocname) {
  //         $("#productReviewIconSrc").attr("src", '/docs/products/A-ATN01-BK/Web_Library/Reviews/' + data.icondocname);
  //         $("#productReviewIconSrc").show();
  //       }
  //       $('#frmProductReviews_status').combobox({
  //         width: 340,
  //         data: [{
  //           text: 'Active',
  //           id: '1'
  //         }, {
  //           text: 'Inactive',
  //           id: '0'
  //         }],
  //         valueField: 'id',
  //         textField: 'text',
  //         label: 'Show Status :',
  //         labelWidth: '140px',
  //         labelAlign: 'right'
  //       });
  //       $('#frmProductReviews_status').combobox('setValue', data.status);

  //       $('#frmPrId').val(selectedrow.id);
  //     }
  //   });
  //   $('#dlgProductReviews').dialog('open');
  // }

  // function delProductReview() {
  //   var selectedrow = $("#productReviewsList").datagrid("getSelected");
  //   if (!selectedrow) {
  //     alert("Please select one of review to DELETE.");
  //   } else {
  //     $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
  //       if (r) {
  //         $('#frmDelPrId').val(selectedrow.id);
  //         $('#delProductReview').form('submit', {
  //           url: 'man_product_reviews.php?action=delete',
  //           success: function (data) {
  //             console.log(data);
  //             $("#productReviewsList").datagrid("reload");
  //           } // end of if confirm
  //         }); // end of confirm messager
  //       }
  //     })
  //   }
  // }



  var cardview_productReviewsList = $.extend({}, $.fn.datagrid.defaults.view, {
    renderRow: function (target, fields, frozen, rowIndex, rowData) {
      var cc = [];
      if (!frozen && rowData.id) {
        cc.push('<td style="padding:10px 5px;border:0; vertical-align:top"">');
        if (rowData.images) {
          cc.push('<img src="/docs/products/A-ATN01-BK/Web_Library/Reviews/' + rowData.images.docname + '" style="width:150px;float:left;overflow: hidden;">');
        } else {
          cc.push('<p>No image has been uploaded. <br>Will use an icon instead of the image.</p>');
        }
        cc.push('</td>');

        cc.push('<td style="padding:10px 5px;border:0; vertical-align:top"">');
        if (rowData.reviewsites) {
          cc.push('<img src="img/product/common/review/' + rowData.reviewsites.sitelogo + '" style="width:100px;float:left;overflow: hidden;" title="' + rowData.reviewsites.sitename + '">');
        }

        cc.push('</td>');
        cc.push('<td style="padding:10px 5px;border:0; vertical-align:top"">');
        cc.push('<span style="color:Blue;width:80px"><b>Title :</b></span><span>' + rowData.title + '</span><br>');
        cc.push('<span style="color:Blue;width:80px"><b>Short Desc :</b></span><span>' + rowData.short_desc + '</span><br>');
        cc.push('<span style="color:Blue;width:80px"><b>Type :</b></span><span>' + rowData.type + '</span><br>');
        cc.push('<span style="color:Blue;width:80px"><b>Seqno :</b></span><span>' + rowData.seqno + '</span><br>');
        cc.push('</td>');
      }
      return cc.join('');
    }
  });

  var cardview_reviewsitesList = $.extend({}, $.fn.datagrid.defaults.view, {
    renderRow: function (target, fields, frozen, rowIndex, rowData) {
      var cc = [];
      if (!frozen && rowData.id) {
        cc.push('<td style="padding:10px 5px;border:0;width:125px;">');
        cc.push('<img src="img/product/common/review/icon/' + rowData.sitelogo + '" style="width:125px;float:left;overflow: hidden;" title="' + rowData.id + '">');
        cc.push('</td>')
        cc.push('<td><b>Name : </b>' + rowData.sitename + '<br><b>Filename : </b>' + rowData.sitelogo+ '<br>');
        cc.push('<b>No of Reviews : </b> : ' + rowData.product_reviews_count + '</td>');
      }
      return cc.join('');
    }
  });
</script>
          <div title="Support" data-options="iconCls:'icon-upload'">
            <div id="supportTabs" class="easyui-tabs" data-options="tabWidth:250" style="width:1850px; height:400px;">
              <div title="Software and Manual" data-options="iconCls:'icon-upload',tabWidth:250">
                <table id="downloadlist" style="width:1390px; height:400px;" class="easyui-datagrid"
                  title="Software Manual"
                  data-options="singleSelect:true,pagination:true,pageSize:'10',sortORder:'asc',sortName:'seqno', url:'mandownload.php?action=list&partno=A-ATN01-BK&imgtype=Download&lang=en',toolbar:'#download_toolbar'">
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
              data-options="singleSelect:'true',pagination:'true',pageSize:'10',sortORder:'asc',sortName:'seqno', width:'1200',height:'800', url:'manimages.php?action=list&partno=A-ATN01-BK&imgtype=Gallery&lang=en',toolbar:'#gallery_toolbar'">
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
                <ul id="folderlist" class="easyui-tree" url="manfile_easyui.php?action=listfolder&id=/akasa/www/docs/products/A-ATN01-BK/">
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
          <div title='Upload Files'>
  <upload-files-directive></upload-files-directive>


<script>
  // config
  const langkeys = Object.keys(aryLangs);

  function uploadFile(efid) {
    //      var selectedrow = $("#blogslist").datagrid("getSelected");
    if (efid == null) {
      alert("Please Select a file record to Export!");
    } else {
      var fd = new FormData()
      fd.append('id', efid);
      $.ajax({
        url: "manupload_files.php?action=upload_single",
        type: 'post',
        data: fd,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
          if (resp.result) {
            $("#uploadfileslist").datagrid("reload");
            $("#uploadFilesTasksList").datagrid("reload");
            alert(" Export File (" + resp.data + ") succssfully.");
          }
        }
      });
    }
  }

  function assignUploadTasks() {
    var selectedrow = $("#uploadfileslist").datagrid("getSelected");
    if (!selectedrow) {
      alert("Please select one of records to UPLOAD.");
    } else {
      //frmUploadFiles_hostname
      $('#dlgUpdate').dialog('open');
    }
  }


  function uploadSelectedFilesNow() {
    var selectedrow = $("#uploadfileslist").datagrid("getSelected");
    if (!selectedrow) {
      alert("Please select one of records to UPLOAD.");
    } else {
      $('#dlgUploadNow').dialog('open');
    }
  }


  function editTask(id) {
    if (!id) {
      alert("Please select one of records to UPLOAD.");
    } else {
      //frmUploadFiles_hostname
      var fd = new FormData();
      fd.append('id', id);
      $.ajax({
        url: "manupload_files.php?action=getOneTask",
        type: 'POST',
        data: fd,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
          console.log(resp.data.launch_datetime);
          var data = JSON.parse(resp.data);
          $('#frmEditTask_status').combobox({
            width: 450,
            data: [{
                text: 'Ready to Upload',
                id: '1',
                "selected": true
              },
              {
                text: 'Pending',
                id: '0'
              },
              {
                text: 'Uploaded',
                id: '2',
                "disabled": true
              },
              {
                text: 'Failed to Upload',
                id: '3',
                "disabled": true
              },

            ],
            valueField: 'id',
            textField: 'text',
            label: 'Status :',
            labelWidth: '140px',
            labelAlign: 'right'
          });
          $('#frmEditTask').form('load', data);
          if (resp.result) {
            $('#dlgEditTasks').dialog('open');
          }
        }
      });

    }
  }

  function uploadSelectedFiles() {
    var selectedrow = $("#uploadfileslist").datagrid("getSelected");
    if (!selectedrow) {
      alert("Please select one of records to UPLOAD.");
    } else {
      var selectedIds = [];
      var dg = $('#uploadfileslist');
      $.map(dg.datagrid('getChecked'), function (row) {
        selectedIds.push(row.id);
      });
      var fd = new FormData();
      fd.append('id', selectedIds.join());
      $.ajax({
        url: "manupload_files.php?action=upload_batch",
        type: 'post',
        data: fd,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
          if (resp.result) {
            $("#uploadfileslist").datagrid("reload");
            $("#uploadFilesTasksList").datagrid("reload");
            alert(" Export Files succssfully.");
          }
        }
      });
    }

  }

  $(document).ready(function () {
        setSessionLang('en');
        setSessionRows('50');
        setSessionPageNo('1');

        $('#uploadfileslist').datagrid({
          url: backendApi + '/file_uploads/list',
          //url: 'manupload_files.php?action=getall',
          // view: cardview_blog,
          // method:'GET',
          toolbar: '#upload_files_toolbar',
          height: '800px',
          singleSelect: false,
          pagination: true,
          pageSize: 50,
          idField: 'id',
          //view: scrollview,
          view: groupview,
          groupField: 'partno',
          groupFormatter: function (value, rows, index) {
            var txt = value + ' - ' + rows.length + ' Item(s)';
            txt = '<input type="checkbox" onclick="groupCheck(\'' + value + '\',event)">&nbsp;' + txt;
            return txt;
          },
          columns: [
            [{
                field: 'keychx',
                checkbox: true
              },
              {
                field: 'id',
                title: 'ID',
                width: '5%',
                sortable: true,
                align: 'center'
              },
              {
                field: 'filename',
                title: 'Filename (Mouseover the name to see file path)',
                width: '45%',
                sortable: true,
                formatter: function (value, row, index) {
                  var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
                  return "<span title='" + titleFilename + "'>" + value + "</span>";
                },
              },
              {
                field: 'etype',
                title: 'File Type',
                width: '15%',
                sortable: true,
                align: 'center'
              },
              {
                field: 'created_at',
                title: 'Created at',
                width: '15%',
                sortable: true
              },
              {
                field: 'updated_at',
                title: 'Updated at',
                width: '15%',
                sortable: true
              },
            ]
          ],
          onLoadSuccess: function () {
            var gcount = $(this).datagrid('options').view.groups.length;
            for (var i = 1; i < gcount; i++) {
              $(this).datagrid('collapseGroup', i);
            }
          }
        });

        // define keyword type
        $('#tools_upartno').textbox({
          width: 240,
          label: 'Search :',
          labelAlign: 'right',
          labelWidth: '50px',
          onKeyup: function (value) {
            $('#uploadfileslist').datagrid('load', {
              etype: $('#tools_fileType').combobox('getValue'),
              partno: value
            });
          },
          onChange: function (value) {
            $('#uploadfileslist').datagrid('load', {
              etype: $('#tools_fileType').combobox('getValue'),
              partno: value
            });
          },
        });
        $('#tools_fileType').combobox({
            width: 210,
            data: [{
                text: 'ALL',
                id: 'all',
                selected: true
              },
               
              {
                text: '[{"id":0,"text":"blog"},{"id":1,"text":"product"},{"id":2,"text":"gallery"},{"id":3,"text":"feature"},{"id":4,"text":"content"},{"id":5,"text":"manual"},{"id":6,"text":"filter"},{"id":7,"text":"search"},{"id":8,"text":"navimenu"},{"id":9,"text":"list"},{"id":10,"text":"Reviews"},{"id":11,"text":"software"},{"id":12,"text":"layout"},{"id":13,"text":"reviewsitelogo"},{"id":14,"text":"reviewsite"}]',
                id: '[{"id":0,"text":"blog"},{"id":1,"text":"product"},{"id":2,"text":"gallery"},{"id":3,"text":"feature"},{"id":4,"text":"content"},{"id":5,"text":"manual"},{"id":6,"text":"filter"},{"id":7,"text":"search"},{"id":8,"text":"navimenu"},{"id":9,"text":"list"},{"id":10,"text":"Reviews"},{"id":11,"text":"software"},{"id":12,"text":"layout"},{"id":13,"text":"reviewsitelogo"},{"id":14,"text":"reviewsite"}]'
              },
                            ],
              valueField: 'id', textField: 'text',
              label: 'File Type :', labelWidth: '82px', labelAlign: 'right',
              onChange: function (value) {
                $('#uploadfileslist').datagrid('load', {
                  etype: value,
                  partno: $('#tools_upartno').textbox('getValue'),
                });
              },
            });

          $('#uploadFilesTasksList').datagrid({
            //url: 'manupload_files.php?action=getAllTasks',
            url: backendApi + '/file_uploads/tasks/list',
            toolbar: '#upload_files_tasks_toolbar',
            height: '800px',
            singleSelect: false,
            pagination: true,
            pageSize: 50,
            idField: 'id',
            //   view: scrollview,
            columns: [
              [{
                  field: 'keychx',
                  checkbox: true
                },
                { field: 'id',title: 'ID',width: '5%',sortable: true,align: 'center'},
                { field: 'hostname',title: 'H',width: '5%',sortable: true,align: 'center'},
                { field: 'filename', title: 'Filename (Mouseover the name to see file path)', width: '35%', sortable: true,
                  formatter: function (value, row, index) {
                    var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
                    return "<span title='" + titleFilename + "'>" + value + "</span>";
                  },
                },
                { field: 'etype', title: 'File Type',width: '10%',sortable: true,align: 'center' },
                { field: 'launch_datetime',title: 'Launch time',width: '13%',sortable: true },
                {
                  field: 'status', title: 'Status', width: '5%',sortable: true,align: 'center',
                  formatter: function (value, row, index) {
                    if (value == 1) {
                      return '<i class="bi bi-toggle-on icon-green icon-fs-md"></i>';
                    } else if (value == 2) {
                      return '<i class="bi bi-check-circle-fill icon-blue icon-fs-md"></i>';
                    } else if (value == 3) {
                      return '<i class="bi bi- icon-red icon-fs-md"></i>';
                    } else {
                      return '<i class="bi bi-toggle-off  icon-grey icon-fs-md"></i>';
                    }
                  },
                },
                { field: 'uploaded_at',title: 'Uploaded at',width: '13%',sortable: true},
                { field: 'created_at',title: 'Created at',width: '13%',sortable: true},
              ]
            ],
            onDblClickRow: function (index, row) {
              editTask(row.id);
            }
          });

          // define keyword type
          $('#tasktools_fileType').combobox({
              width: 210,
              data: [{
                  text: 'ALL',
                  id: 'all',
                  selected: true
                },
                 {
                  text: '[{"id":0,"text":"blog"},{"id":1,"text":"product"},{"id":2,"text":"gallery"},{"id":3,"text":"feature"},{"id":4,"text":"content"},{"id":5,"text":"manual"},{"id":6,"text":"filter"},{"id":7,"text":"search"},{"id":8,"text":"navimenu"},{"id":9,"text":"list"},{"id":10,"text":"Reviews"},{"id":11,"text":"software"},{"id":12,"text":"layout"},{"id":13,"text":"reviewsitelogo"},{"id":14,"text":"reviewsite"}]',
                  id: '[{"id":0,"text":"blog"},{"id":1,"text":"product"},{"id":2,"text":"gallery"},{"id":3,"text":"feature"},{"id":4,"text":"content"},{"id":5,"text":"manual"},{"id":6,"text":"filter"},{"id":7,"text":"search"},{"id":8,"text":"navimenu"},{"id":9,"text":"list"},{"id":10,"text":"Reviews"},{"id":11,"text":"software"},{"id":12,"text":"layout"},{"id":13,"text":"reviewsitelogo"},{"id":14,"text":"reviewsite"}]'
                },
                                ],
                valueField: 'id', textField: 'text', label: 'File Type :', labelWidth: '82px', labelAlign: 'right',
                onChange: function (value) {
                  $('#uploadFilesTasksList').datagrid('load', {
                    etype: value,
                    partno: $('#tasktools_upartno').val(),
                  });
                },
              });

            $('#tasktools_upartno').textbox({
              width: 240,
              label: 'Search :',
              labelAlign: 'right',
              labelWidth: '50px',
              onKeyup: function (value) {
                $('#uploadFilesTasksList').datagrid('load', {
                  etype: $('#tasktools_fileType').combobox('getValue'),
                  partno: value,
                });
              },
              onChange: function (value) {
                $('#uploadFilesTasksList').datagrid('load', {
                  etype: $('#tasktools_fileType').combobox('getValue'),
                  partno: value,
                });
              },
            });


          });



        function delUploadFiles() {
          var selectedrow = $("#uploadfileslist").datagrid("getSelected");
          if (!selectedrow) {
            alert("Please select one of records to DELETE.");
          } else {
            $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
              if (r) {

                var selectedIds = [];
                var dg = $('#uploadfileslist');
                $.map(dg.datagrid('getChecked'), function (row) {
                  selectedIds.push(row.id);
                });

                $('#frmDelUploadFilesId').val(selectedIds.join());
                $('#delUploadFiles').form('submit', {
                  url: backendApi + "/file_uploads/delete",
                  // url: 'manupload_files.php?action=delete&lang=en',
                  success: function (resp) {
                    $("#uploadfileslist").datagrid("reload");
                    $("#uploadFilesTasksList").datagrid("reload");
                  } // end of if confirm
                }); // end of confirm messager
              }
            })
          }
        }

        function submitUploadForm() {
          inProgress();
          var selectedIds = [];
          var dg = $('#uploadfileslist');
          $.map(dg.datagrid('getChecked'), function (row) {
            selectedIds.push(row.id);
          });
          $('#frmUploadFiles_id').val(selectedIds.join());
          $('#frmUploadFiles').form('submit', {
            //url: 'manupload_files.php?action=update_datetime_hostname&lang=en',
            url: backendApi + "/file_uploads/schedule_tasks",
            success: function (data) {
              if (data) {
                $("#uploadfileslist").datagrid("reload");
                $("#uploadFilesTasksList").datagrid("reload");
                endProgress("Uploaded", "Files has been uploaded successfully!", '');
              } else {
                endProgress("Failed", "Failed to upload ", 'error');
              }
              $('#dlgUpdate').dialog('close');

            }
          });
        }

        function uploadFilesTasksList() {
          $('#frmUploadFiles').form('submit', {
            url: 'manupload_files.php?action=update_datetime_hostname&lang=en',
            success: function (data) {
              $('#dlgUpdate').dialog('close');
              $("#uploadfileslist").datagrid("reload");
              $("#uploadFilesTasksList").datagrid("reload");
            }
          });
        }

        function cancelUploadForm() {
          $('#dlgUpdate').dialog('close');
          $('#frmUploadFiles').form('clear');
        }

        /*****      Upload now        ********/
        function submitUploadNowForm() {
          inProgress();
          var selectedIds = [];
          var dg = $('#uploadfileslist');
          $.map(dg.datagrid('getChecked'), function (row) {
            selectedIds.push(row.id);
          });
          $('#frmUploadNow_id').val(selectedIds.join());
          $('#frmUploadNow').form('submit', {
            //url: 'manupload_files.php?action=upload_batch_now&lang=en',
            url: backendApi + '/file_uploads/upload_batch_now',
            success: function (resp) {
              console.log(resp);
              if (resp) {
                $("#uploadfileslist").datagrid("reload");
                $("#uploadFilesTasksList").datagrid("reload");
                endProgress("Uploaded", "Files has been uploaded successfully!", '');
              } else {
                endProgress("Failed", "Failed to upload ", 'error');
              }
              $('#dlgUploadNow').dialog('close');
            }
          });
        }

        function cancelUploadNowForm() {
          $('#dlgUploadNow').dialog('close');
          $('#frmUploadNow').form('clear');
        }
        /*****      edit task        ********/
        function submitEditTasksForm() {
          inProgress();
          $('#frmEditTask').form('submit', {
            url: 'manupload_files.php?action=edit_single_task&lang=en',
            success: function (data) {
              if (resp) {
                $("#uploadFilesTasksList").datagrid("reload");
                endProgress("Uploaded", "Upload job has been assigned successfully!", '');
              } else {
                endProgress("Failed", "Failed to assign ", 'error');
              }
              cancelDlgFrm('dlgEditTasks', 'frmEditTask')
            }
          });
        }
        /*****      execute task        ********/
        function executeTasks() {
          var selectedrow = $("#uploadFilesTasksList").datagrid("getSelected");
          if (!selectedrow) {
            alert("Please select one of Tasks");
          } else {

            inProgress();
            var selectedIds = [];
            var dg = $('#uploadFilesTasksList');
            $.map(dg.datagrid('getChecked'), function (row) {
              selectedIds.push(row.id);
            });

            var fd = new FormData();
            fd.append('id', selectedIds.join());
            $.ajax({
              // url: "manupload_files.php?action=execute_task",
              url: backendApi + "/file_uploads/execute_tasks",
              type: 'post',
              data: fd,
              async: true,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function (resp) {
                if (resp.result) {
                  $("#uploadfileslist").datagrid("reload");
                  $("#uploadFilesTasksList").datagrid("reload");
                  endProgress("Uploaded", " Files uploaded succssfully.", '');
                } else {
                  endProgress("Failed", " Failed to upload file, Please check the local file is existed or not.",
                    'error');
                }
              }
            });

          }
        }
        /*****      delete task        ********/
        function delTasks() {
          var selectedrow = $("#uploadFilesTasksList").datagrid("getSelected");
          if (!selectedrow) {
            alert("Please select one of records to DELETE.");
          } else {
            $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
              if (r) {
                var selectedIds = [];
                var dg = $('#uploadFilesTasksList');
                $.map(dg.datagrid('getChecked'), function (row) {
                  selectedIds.push(row.id);
                });
                $('#frmDelUploadFilesId').val(selectedIds.join());
                $('#delUploadFiles').form('submit', {
                  //url: 'manupload_files.php?action=del_tasks&lang=en',
                  url: backendApi + "/file_uploads/tasks/delete",
                  success: function (resp) {
                    $("#uploadFilesTasksList").datagrid("reload");
                  } // end of if confirm
                }); // end of confirm messager
              }
            })
          }
        }

        function groupCheck(value, event) {
          value = $.trim(value);
          var dg = $('#uploadfileslist');
          var groups = dg.datagrid('groups');
          var group = null;
          for (var i = 0; i < groups.length; i++) {
            if (groups[i].value == value) {
              group = groups[i];
              break;
            }
          }
          var checked = $(event.target).is(':checked');
          for (var i = group.startIndex; i < group.startIndex + group.rows.length; i++) {
            dg.datagrid(checked ? 'checkRow' : 'uncheckRow', i)
          }
        }
</script>
<script type="text/javascript">
  $.extend($.fn.textbox.defaults.inputEvents, {
    keyup: function (e) {
      var t = $(e.data.target);
      t.textbox('setValue', t.textbox('getText'));
    }
  });
</script>          <!-- End published list tab-->
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
    <input type="text" id="frmCopyProduct_lang" name="lang" value="en" hidden=true>
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
    <input type="text" id="lang" name="lang" value="en" hidden=true>
    <input type="text" id="partno" name="partno" value="A-ATN01-BK" hidden=true>

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
    <input name="id" type="hidden" value="3522">
    <input name="partno" type="hidden" value="A-ATN01-BK">
    <input id="cc1" name="intro_display_type" class="easyui-combobox" data-options="
        valueField: 'id',
        textField: 'text',
        label:'Display Type:',
        labelPosition:'left',
        labelWidth:'140px',
        width:'100%',
        labelAlign: 'Right',
        url: 'manproducts.php?action=intro_display_options&id=3522',
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
        <input name="id" type="hidden" value="3522">
        <input name="partno" type="hidden" value="A-ATN01-BK">
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
            <input name="id" type="hidden" value="3522">
            <input name="partno" type="hidden" value="A-ATN01-BK">
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
  <input name="id" type="hidden" value="3522">
  <input name="partno" type="hidden" value="A-ATN01-BK">
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
                <input name="id" type="hidden" value="3522">
                <input name="partno" type="hidden" value="A-ATN01-BK">
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
          <input name="id" type="hidden" value="3522">
          <input name="partno" type="hidden" value="A-ATN01-BK">
          <input name="lang" type="hidden" value="en">

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
          <input name="lang" type="hidden" value="en">
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
                <input type="text" id="imf_lang" name="lang" value=en hidden=true>
                <input type="text" id="imf_partno" name="partno" value=A-ATN01-BK hidden=true>

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
                <input type="text" id="dnf_lang" name="lang" value=en hidden=true>
                <input type="text" id="dnf_partno" name="partno" value=A-ATN01-BK hidden=true>

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

            <script>
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
                    cc.push('<img src="/docs/products/A-ATN01-BK/Web_Library/Features/' + img + '" style="width:150px;float:left">');
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
                    cc.push('<img src="/docs/products/A-ATN01-BK/Web_Library/Specification/' + img + '" style="width:150px;float:left">');
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
                    cc.push('<img src="/docs/products/A-ATN01-BK/Web_Library/Gallery/' + img + '" style="width:150px;float:left">');
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
                    cc.push('<img src="/docs/products/A-ATN01-BK/Web_Library/Contents/' + img + '" style="width:150px;float:left">');
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
                    cc.push('<video src="/docs/products/A-ATN01-BK/Web_Library/Movies/' + img + '#t=3" type="video/mp4" style="width:150px;float:left"></video>');
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
                var url = "manproducts.php?action=getintroduction&id=3522";
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

                var url = "manproducts.php?action=getintroduction&id=3522";
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
                var url = "manproducts.php?action=getdescription&id=3522";
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
                var url = "manproducts.php?action=getnote&id=3522";
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

            </script>

            <script>
              var faqeditmode = '0';
              var partno = 'A-ATN01-BK';
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
                  url: 'manprodfaq.php?action=list&productcode=A-ATN01-BK&lang=en',
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
                      url: "manprodfaq.php?action=getrow2edit&id=" + srow.id + "&lang=en",
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
                  $("#faq_lang").val('en');
                  $("#faq_partno").val('A-ATN01-BK');
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
                  fd.append('partno','A-ATN01-BK');

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
                    fd.append('partno','A-ATN01-BK');


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
            </script>


            <script>
              function delimage(ctype, typelist) {
                var srow = $(typelist).datagrid("getSelected");
                console.log(srow);
                if (srow == null) {
                  alert("Please Select an Image to Delete!");
                } else {
                  
                  $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
                    if (r) {
                      $.ajax({
                        url: "manimages.php?action=delete&ctype=" + ctype + "&id=" + srow.id +"&docname="+srow.docname+'&partno=A-ATN01-BK',
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
                $('#imf_lang').val('en');
                $('#imf_partno').val('A-ATN01-BK');
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
                $('#dnf_lang').val('en');
                $('#dnf_partno').val('A-ATN01-BK');
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
                    previewFileInDlg(row.docname, '/docs/products/A-ATN01-BK/Web_Library/Download/' + row.docname);
                  }
                });
              });
              $(function () {
                $('#featurelist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/A-ATN01-BK/Web_Library/Features/' + row.docname);
                    // $("#viewImageSrc").attr("src", '/docs/products/A-ATN01-BK/Web_Library/Features/' + row.docname);
                    // $("#viewImageSrc").show();
                    // $('#dlgViewImage').dialog('open');
                    //  OpenInNewTab('/docs/products/A-ATN01-BK/Web_Library/Features/'+row.docname);
                  }
                });
              });
              $(function () {
                $('#gallerylist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/A-ATN01-BK/Web_Library/Gallery/' + row.docname);
                  }
                });
              });
              $(function () {
                $('#contentlist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/A-ATN01-BK/Web_Library/Contents/' + row.docname);
                  }
                });
              });
              $(function () {
                $('#movielist').datagrid({
                  onDblClickRow(index, row) {
                    previewFileInDlg(row.docname, '/docs/products/A-ATN01-BK/Web_Library/Movies/' + row.docname);
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
                      url: "mankeywordlist.php?action=getprodkeyword&partno=A-ATN01-BK",
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
            </script>

<!-- footer -->
<script type="text/javascript" src="/marketing/js/bootstrap.min.js"></script>
</html><?php }
}
