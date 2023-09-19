<?php
/* Smarty version 3.1.34-dev-7, created on 2023-06-16 15:51:05
  from '/akasa/www/marketing/templates/product_reviews.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_648c84e9cf1c35_44808808',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3eb7dc035c14e786c88d9d9b67114b367c0ba0bb' => 
    array (
      0 => '/akasa/www/marketing/templates/product_reviews.tpl',
      1 => 1686930664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_648c84e9cf1c35_44808808 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '256934864648c84e9ceff49_49541284';
?>
<div title="Reviews" data-options="iconCls:'icon-hand-thumbs-up'">
  <div title="Product Reviews" data-options="iconCls:'icon-image'">
    <div style="width:300px;height:800px;float:left;">
      <reviewsites-directive></reviewsites-directive>
    </div>
    <div style="width:530px;height:800px;float:left;">
      <prod-reviews-directive></prod-reviews-directive>
    </div>

  </div>
  <table id="productReviewsList" class="easyui-datagrid" title="Product Reviews - <?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
 <?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
"></table>
  <div id='productReviewsList_toolbar'>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-plus" plain="true"
      onclick="openProductReviewsForm()">Add Review</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-pencil" plain="true"
      onclick="editProductReviewsForm()">Edit Review</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-trash" plain="true"
      onclick="delProductReview()">Delete Review</a>
  </div>
</div>

<form id="delProductReview" enctype="multipart/form-data" method="post">
  <input type="text" id="frmDelPrId" name="id" value="" hidden=true>
</form>



<?php echo '<script'; ?>
>
  $(function () {
    $('#productReviewsList').datagrid({
      view: cardview_productReviewsList,
      width: '800px',
      idField: 'id',
      singleSelect: true,
      url: 'man_product_reviews.php?action=list&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
&partno=<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
',
      toolbar: '#productReviewsList_toolbar',
      columns: [[
        { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
        { field: 'title', title: 'Title', width: 35, hidden: true },
        { field: 'web_link', title: 'Link', width: 35, hidden: true },
        { field: 'type', title: 'Type', width: 35, hidden: true },
        { field: 'docname', title: 'File Name', width: 35, sortable: true, hidden: true },
        { field: 'seqno', title: 'Seqno', width: 35, hidden: true },
        { field: 'caption', title: 'Caption', width: 35, hidden: true },
        { field: 'comment', title: 'Comment', width: 35, hidden: true },
        { field: 'status', title: 'Status', width: 35, hidden: true },
      ]]
    });

    $('#productReviewsList').datagrid({
      onDblClickRow(index, row) {// make it popup and TODO ::  edit 
        console.log(row);

        $("#viewImageSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + row.docname);
        $('#dlgViewImage').dialog('open');
      }
    });
  });

  function openProductReviewsForm() {
    $('#frmProductReviews').form('clear');
    var data = {
      'ctype': 'Reviews',
      'lang': "<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
      'partno': "<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
",
    }
    $('#frmProductReviews').form('load', data);
    $("#productReviewImageSrc").css("display", "none");
    $("#productReviewIconSrc").css("display", "none");
    $('#product_review_file').show();
    $("#pr_shortdesc_id").summernote('reset');
    $('#frmPrId').val("");
    $("#pr_shortdesc_id").summernote({ 'height': 300 });
    $('#frmProductReviews_status').combobox({
      width: 340,
      data: [{
        text: 'Active',
        id: '1',
        selected: true
      }, {
        text: 'Inactive',
        id: '0'
      }],
      valueField: 'id', textField: 'text', label: 'Show Status :', labelWidth: '140px', labelAlign: 'right'
    });
    $('#frmProductReviews_icons').combobox({
      width: 340,
      //var productWithImgUrl = backendApi + "/product/images_list";
      url: backendApi + "/reviewsites/list",
      valueField: 'id', textField: 'sitename', label: 'Comp. Icon :', labelWidth: '80px', labelAlign: 'right'
    });

    $('#dlgProductReviews').dialog('open');
  }

  function cancelProductReviewsForm() {
    $('#dlgProductReviews').dialog('close');
  }

  function submitProductReviewsForm() {
    $('#frmProductReviews').form('submit', {
      url: 'man_product_reviews.php?action=save',
      success: function (data) {
        $("#productReviewsList").datagrid("reload");
        $('#dlgProductReviews').dialog('close');
      }
    });
  }
  function editProductReviewsForm() {
    var selectedrow = $("#productReviewsList").datagrid("getSelected");
    if (!selectedrow) {
      alert("Please select one of review to Edit.");
    }

    //$('#frmProductReviews').form('load', "man_product_reviews.php?action=getdata&id="+selectedrow.id);
    $.ajax({
      url: "man_product_reviews.php?action=getdata&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
&id=" + selectedrow.id,
      type: "GET",
      dataType: "json",
      success: function (data) {
        console.log(data);
        $('#frmProductReviews').form('load', data);
        $("#pr_shortdesc_id").summernote('reset');
        $("#pr_shortdesc_id").summernote('code', data.short_desc);
        // set preview image
        if (data.docname) {
          $("#productReviewImageSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + data.docname);
          $("#productReviewImageSrc").css("display", "block");
        }
        if (data.icondocname) {
          $("#productReviewIconSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + data.icondocname);
          $("#productReviewIconSrc").show();
        }
        $('#frmProductReviews_status').combobox({
          width: 340,
          data: [{
            text: 'Active',
            id: '1'
          }, {
            text: 'Inactive',
            id: '0'
          }],
          valueField: 'id',
          textField: 'text',
          label: 'Show Status :',
          labelWidth: '140px',
          labelAlign: 'right'
        });
        $('#frmProductReviews_status').combobox('setValue', data.status);

        $('#frmPrId').val(selectedrow.id);
      }
    });
    $('#dlgProductReviews').dialog('open');
  }

  function delProductReview() {
    var selectedrow = $("#productReviewsList").datagrid("getSelected");
    if (!selectedrow) {
      alert("Please select one of review to DELETE.");
    } else {
      $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
        if (r) {
          $('#frmDelPrId').val(selectedrow.id);
          $('#delProductReview').form('submit', {
            url: 'man_product_reviews.php?action=delete',
            success: function (data) {
              console.log(data);
              $("#productReviewsList").datagrid("reload");
            } // end of if confirm
          }); // end of confirm messager
        }
      })
    }
  }


  var cardview_productReviewsList = $.extend({}, $.fn.datagrid.defaults.view, {
    renderRow: function (target, fields, frozen, rowIndex, rowData) {
      var cc = [];
      cc.push('<td colspan=' + fields.length + ' style="padding:10px 5px;border:0;">');
      if (!frozen && rowData.id) {
        var img = rowData.docname;
        cc.push('<img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + img + '" style="width:150px;float:left;overflow: hidden;">');
        cc.push('<div style="float:left;margin-left:20px;width:500px;">');
        for (var i = 1; i < fields.length; i++) {
          var copts = $(target).datagrid('getColumnOption', fields[i]);
          if (copts.field == 'status') {
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

  var cardview_reviewsitesList = $.extend({}, $.fn.datagrid.defaults.view, {
    renderRow: function (target, fields, frozen, rowIndex, rowData) {
      var cc = [];
      if (!frozen && rowData.id) {
      cc.push('<td style="padding:10px 5px;border:0;width:125px;">');
        var img = rowData.sitelogo;
        cc.push('<img src="img/product/common/review/' + img + '" style="width:125px;float:left;overflow: hidden;">');
        cc.push('</td>')
        cc.push('<td><b>Name : </b>'+rowData.sitename+'<br>');
        cc.push('<b>No of Reviews : </b> : '+rowData.product_reviews_count+'</td>');
      }
      return cc.join('');
    }
  });
<?php echo '</script'; ?>
><?php }
}
