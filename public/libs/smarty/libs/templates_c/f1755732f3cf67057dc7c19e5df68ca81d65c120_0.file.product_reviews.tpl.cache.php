<?php
/* Smarty version 3.1.34-dev-7, created on 2023-07-25 07:48:04
  from '/akasa/www/marketing/templates/products/product_reviews.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64bf7e34492d72_29758684',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f1755732f3cf67057dc7c19e5df68ca81d65c120' => 
    array (
      0 => '/akasa/www/marketing/templates/products/product_reviews.tpl',
      1 => 1690271282,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64bf7e34492d72_29758684 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '175795116164bf7e344915a5_24704479';
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
  <product-reviews-directive></product-reviews-directive>
</div>

<?php echo '<script'; ?>
>
  // $(function () {

  // });

  // function openProductReviewsForm() {
  //   $('#frmProductReviews').form('clear');
  //   var data = {
  //     'ctype': 'Reviews',
  //     'lang': "<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
  //     'partno': "<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
",
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
  //     url: "man_product_reviews.php?action=getdata&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
&id=" + selectedrow.id,
  //     type: "GET",
  //     dataType: "json",
  //     success: function (data) {
  //       console.log(data);
  //       $('#frmProductReviews').form('load', data);
  //       $("#pr_shortdesc_id").summernote('reset');
  //       $("#pr_shortdesc_id").summernote('code', data.short_desc);
  //       // set preview image
  //       if (data.docname) {
  //         $("#productReviewImageSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + data.docname);
  //         $("#productReviewImageSrc").css("display", "block");
  //       }
  //       if (data.icondocname) {
  //         $("#productReviewIconSrc").attr("src", '/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + data.icondocname);
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
          cc.push('<img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Reviews/' + rowData.images.docname + '" style="width:150px;float:left;overflow: hidden;">');
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
<?php echo '</script'; ?>
><?php }
}
