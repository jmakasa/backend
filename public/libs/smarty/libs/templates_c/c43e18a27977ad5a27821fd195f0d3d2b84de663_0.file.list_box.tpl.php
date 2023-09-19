<?php
/* Smarty version 3.1.34-dev-7, created on 2023-08-09 10:31:21
  from '/akasa/www/marketing/templates/products/list_box.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64d36af91bacd5_35564808',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c43e18a27977ad5a27821fd195f0d3d2b84de663' => 
    array (
      0 => '/akasa/www/marketing/templates/products/list_box.tpl',
      1 => 1690555122,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/navmenu.tpl' => 1,
    'file:newmenu_2022.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_64d36af91bacd5_35564808 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<style>
  .datagrid-cell {
    font-size: 12px;
  }

  .datagrid-header .datagrid-cell span {
    font-weight: bold;
    font-size: 12px;
  }

  .icon-export {
    background: transparent url("/easyui/themes/icons/export.svg") no-repeat scroll center center;
  }

  .green-tooltip .tooltip-inner {
    background-color: #008000;
  }

  .blue-tooltip+.tooltip>.tooltip-inner {
    background-color: #0000FF;
  }

  .violet-tooltip+.tooltip>.tooltip-inner {
    background-color: #9400D3;
  }

  .orange-tooltip+.tooltip>.tooltip-inner {
    background-color: #FFA500;
  }

  .yellow-tooltip+.tooltip>.tooltip-inner {
    background-color: #FFFF00;
  }

  .red-tooltip+.tooltip>.tooltip-inner {
    background-color: #f00;
  }
</style>
<!-- START cart -->
<style type="text/css">
  .products {
    float: left;
    overflow: auto;
    height: 100%;
    background: #fafafa;
  }

  .products ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .products li {
    display: inline;
    float: left;
    margin: 10px;
    border: 1px solid #000000;
  }

  .item {
    display: block;
    width: 110px;
    height: 110px;
    text-decoration: none;
    overflow: hidden;
  }

  .item img {
    width: 110px;
  }

  .newbox,
  .newproduct,
  .removebox {
    display: block;
    height: 70px;
    width: 30%;
    margin: 0px 10px 0 0;
    float: left;
    font-size: 14px;
  }

  .newproduct p {
    color: #0d00c4;
    border: 3px solid #0d00c4;
    text-align: center;
    padding: 15px 0px;
  }

  .newbox p {
    border: 3px solid #000000;
    text-align: center;
    padding: 15px 0px;
  }

  .removebox p {
    color: red;
    border: 3px solid #7e7e7e;
    text-align: center;
    padding: 15px 0px;
  }

  .green-box {
    color: #fff;
    background-color: green;
  }

  .red-box {
    color: #fff;
    background-color: rgb(173, 0, 0);
  }

  .blue-box {
    color: #fff;
    background-color: #0d00c4;
  }

  .group-box {
    background-color: #00afaf !important;
    color: rgb(207, 255, 131);
  }

  .box_content_img {
    width: 25%;
    float: left;
    display: block;
  }

  .box_content_img .list_img {
    width: 150px;
    padding: 5px;
  }

  .box_content_left {
    width: 30%;
    float: left;
    display: block;
    white-space: initial;
  }

  .box_content_right {
    width: 45%;
    float: left;
    display: block;
    white-space: initial;
  }

  .main_panel {
    width: 100%;
    float: left;
    margin-right: 10px;
    overflow: hidden;
  }

  .old {
    margin-top: 115px;
  }

  .panel-body {
    max-height: 790px;
  }

  .allboxes .panel-body {
    overflow: hidden;
  }

  .allboxes .datagrid-body {
    height: 760px !important;
  }

  .lbl_140 {
    text-align: left;
    width: 140px;
    height: 30px;
    line-height: 30px;
  }

  .category_box {
    width: 230px;
    height: 70px;
  }
</style>
<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid">
    <div class="row">
      <div class="col col-lg-8">
        <?php $_smarty_tpl->_subTemplateRender('file:newmenu_2022.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="openCreateProductForm()"><i
          class="bi bi-plus-circle"></i>&nbsp;Create
        Product</a>
        
      </div>
      <div class="col col-lg-4">
      
        <div class="nav_right">
          <div class="newproduct" id="drop-area">
            <p><img src="/icons-main/icons/file-earmark-plus.svg"> Drop New Product</p>
          </div>
          <div class="newbox" id="NEW">
            <p><img src="/icons-main/icons/box-arrow-in-down.svg"> Drop to New box</p>
          </div>
          <div class="removebox" id="remove">
            <p><img src="/icons-main/icons/trash.svg"> Drop to Remove</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col col-lg-6 p-2">
        <div class="panel main_panel <?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
">
          <div class="panel-header">
            <div class="panel-title" id="allProductsTitle">All Products</div>
            <div class="panel-tool"></div>
          </div>
          <div class="panel-body allProductsPanelBody">
            <div id="allproducttoolbar" style="height:85px;" class="datagrid-toolbar">
              <div style="height:30px;margin-top:5px;">
                <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="switchProductListView('grid')"><i
                  class="bi bi-arrow-repeat"></i>&nbsp;Switch View</a>
                <span class="textbox combo" style="width: 400px;">
                  <span class="textbox-addon textbox-addon-right" style="right: 0px; top: 0px;">
                    <a onclick="getListProduct()" href="javascript:;" class="textbox-icon icon-bootsearch"
                      icon-index="0" tabindex="-1" style="width: 26px; height: 28px;"></a>
                    <a onclick="resetInput()" href="javascript:;" class="textbox-icon icon-arrow-counterclockwise"
                      icon-index="1" tabindex="-1" style="width: 26px; height: 28px;"></a></span>
                  <input id="search_partno" name="partno" value="" type="text" class="textbox-text textbox-prompt"
                    autocomplete="off" tabindex="" placeholder="Search Product Code..."
                    style="margin: 0px 52px 0px 0px; padding-top: 0px; padding-bottom: 0px; height: 28px; line-height: 28px; width: 346px;">
                </span>
                <select onchange="getListProduct()" id="rows" name="rows" class="easyui-combobox rows"
                  style="width: 60px; float:right; display:inline" textboxname="rows" comboname="rows">
                  <option value="20">20</option>
                  <option value="50" selected>50</option>
                  <option value="100">100</option>
                  <option value="150">150</option>
                  <option value="200">200</option>
                  <option value="all">ALL</option>
                </select>
                <a href="#" class="easyui-linkbutton" id="edit_product_ps" onclick='pstatus()'
                  data-options="iconCls:'icon-edit',plain:true">Change Status</a>
                  
                    <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="exportBatchProduct()"><i
                      class="bi bi-file-arrow-down"></i>&nbsp;Export Product detail</a>
                <br>
                <div style="padding:5px">
                  <input class="easyui-checkbox" id="ckb_upcoming" name="upcoming" value="upcoming" label="Upcoming:">
                  <input class="easyui-checkbox" id="ckb_new" name="new" value="new" label="NEW:">
                  <input class="easyui-checkbox" id="ckb_iscooler" name="new" value="IsCooler" label="IsCooler:">
                  <input class="easyui-checkbox" id="ckb_eol" name="new" value="eol" label="EOL:">
                </div>
              </div>
            </div>
            <ul class="products" id="imgListProducts"></ul>
            <div id="productGrid">
              <table id="listProducts"></table>
            </div>
          </div>
        </div>
      </div>
      <div class="col col-lg-6 p-2">
        <div class="panel allboxes main_panel <?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
" id="view_boxes">
          <div class="panel-header">
            <div class="panel-title" id="allBoxesTitle">All Boxes</div>
            <div class="panel-tool"><a href="javascript:void(0)" class="" style="width: auto;font-size: 12px;"
                onclick="exportweblist()">Export to AKASA2206 Web List</a></div>
          </div>
          <div class="panel-body">
            <div id="boxestoolbar" style="height:45px;" class="datagrid-toolbar">
              <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="switchBoxView('grid')"><i
                  class="bi bi-arrow-repeat"></i>&nbsp;Grid View</a>
              <div class="float-end">
                <a href="#" class="btn btn-sm btn-orange" id="edit_product_ps" onclick="pstatus()"><i
                    class="bi bi-pencil"></i>&nbsp;Edit Product</a>
                <a href="#" class="btn btn-sm btn-orange" id="edit_product_ps" onclick="openEditBox()"><i
                    class="bi bi-pencil"></i>&nbsp;Edit Box</a>
              </div>
              <span id="totBoxesInMenucat"></span>
              <span id="totProductsInBoxes"></span>
            </div>

            <div id="boxes" style="width:auto;height:795px;margin-top:5px;float:left;overflow:auto"></div>
          </div>
        </div>
        <div class="panel allboxes main_panel <?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
" id="view_boxes_grid">
          <div class="panel-header">
            <div class="panel-title" id="allBoxesTitleGrid">Boxes Grid</div>
            <div class="panel-tool"><a href="javascript:void(0)" class="" style="width: auto;font-size: 12px;"
                onclick="exportweblist()">Export to AKASA2206 Web List</a></div>
          </div>
          <div class="panel-body">
            <div id="boxestoolbar" style="height:45px;" class="datagrid-toolbar">
              <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="switchBoxView('box')"><i
                  class="bi bi-arrow-repeat"></i>&nbsp;Box View</a>
              <div class="float-end">
                <a href="#" class="btn btn-sm btn-orange" id="edit_product_ps" onclick="pstatus()"><i
                    class="bi bi-pencil"></i>&nbsp;Edit Product</a>
                <a href="#" class="btn btn-sm btn-orange" id="edit_product_ps" onclick="openEditBox()"><i
                    class="bi bi-pencil"></i>&nbsp;Edit Box</a>
              </div>
              <span id="totBoxesInMenucat2"></span>
              <span id="totProductsInBoxes2"></span>
            </div>
            <table id="boxes_grid" style="width:auto;"></table>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END cart -->
  <?php echo '<script'; ?>
>

 //   var backendApi = "../backend/public/<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
/api";
 // change language
function pageReloadDatagrid(){
  // reload datagrid
  //$('#listProducts').datagrid("reload");
        reloadBoxes();
        reloadBoxesGrid();
        reloadListProduct();
        setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
}
 // end change language

    function setPanelTitleWithLang(lang, title = "") {
      if (title) {
        title = " | " + title + " ";
      }
      //  $("#allProductsTitle").text('Products' + title + ' | ' + aryLangs[lang]);
      $("#allBoxesTitle").text('Boxes ' + title + ' | ' + aryLangs[lang]);
      $("#allBoxesTitleGrid").text('Boxes ' + title + ' | ' + aryLangs[lang]);

    }

    function setNumberOfBoxestoolbar(totBoxes, totProducts) {
      // set tot boxes and product 
      totBoxes =(totBoxes ? totBoxes : '0');
      totProducts =(totProducts ? totProducts : '0');
      $('#totBoxesInMenucat').text("Total Boxes : " + totBoxes);
      $('#totProductsInBoxes').text("Total Products : " + totProducts);
      $('#totBoxesInMenucat2').text("Total Boxes : " + totBoxes);
      $('#totProductsInBoxes2').text("Total Products : " + totProducts);  
    }
    function resetNumberOfBoxestoolbar() {
      // set tot boxes and product 
      $('#totBoxesInMenucat').text('');
      $('#totProductsInBoxes').text('');
    }

    function switchBoxView(view) {
      if (view == "grid") {
        $("#view_boxes").hide();
        $("#view_boxes_grid").show();
        reloadBoxes();
        reloadBoxesGrid();
      } else {

        $("#view_boxes").show();
        $("#view_boxes_grid").hide();
        reloadBoxes();
        reloadBoxesGrid();
      }
    }
   
    function switchProductListView(sv) {
      var view = getSession('viewproducts');
      if (sv == view) {
        setSession('viewproducts','box');
        $("#imgListProducts").hide();
        $("#productGrid").show();
      } else {
        setSession('viewproducts','grid');
        $("#imgListProducts").show();
        $("#productGrid").hide();
      }
      getListProduct();
      reloadListProduct();
    }



    $(document).ready(function () {
     // setSessionLang('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
      setSessionRows('50');
      setSessionPageNo('1');
      switchBoxView('grid');
      //console.log(getSessionLang());
      setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
      getListProduct();
      //* input easy ui defining */
      $('#ckb_upcoming').checkbox({
        label: 'Upcoming:',
        value: 'upcoming',
        labelAlign: 'Right',
        onChange: function () {
          getListProduct();
          reloadListProduct();
        }

      });
      $('#ckb_new').checkbox({
        label: 'NEW:',
        value: 'NEW',
        labelAlign: 'Right',
        onChange: function () {
          getListProduct();
          reloadListProduct();
        }

      });
      $('#ckb_eol').checkbox({
        label: 'eol:',
        value: 'eol',
        labelAlign: 'Right',
        onChange: function () {
          getListProduct();
          reloadListProduct();
        }

      });
      $('#ckb_iscooler').checkbox({
        label: 'isCooler:',
        value: 'iscooler',
        labelAlign: 'Right',
        onChange: function () {
          getListProduct();
          reloadListProduct();
        }

      });

      $("#rows").combobox({
        editable: false,
        onClick: function (record) {
          setSessionRows(record.value);
          getListProduct();
          reloadListProduct();
        }
      });

      // checking scroll
      $('.allProductsPanelBody').scroll(function () {
        var productPanel = $(this);
        //    console.log(productPanel.height()  +","+productPanel.scrollTop());
        if (productPanel.height() < productPanel.scrollTop() + 1) //scrollTop is 0 based
        {
          console.log(" reach bottom  -  get list pls ");
          setSessionPageNo(getSessionPageNo + 1);
          //   getListProduct();
        }
      });



      $('#edit_ps').hide();
      $('#edit_product_ps').hide();
     // $(document).ready(function () {
        $("#drop-area").on("dragover", function (event) {
          event.preventDefault();
          event.stopPropagation();
          $(this).find('p').addClass('blue-box');
          $(this).addClass('dragging');
        });

        $("#drop-area").on("dragleave", function (event) {
          event.preventDefault();
          event.stopPropagation();
          $(this).find('p').removeClass('blue-box');
          $(this).removeClass('dragging');
        });

        $("#drop-area").on("drop", function (event) {
          event.preventDefault();
          event.stopPropagation();
          var image = event.originalEvent.dataTransfer.files;
          $(this).find('p').removeClass('blue-box');
          var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
          if (!allowedExtensions.exec(image[0].name)) {
            alert('Please upload file having extensions .jpeg/.jpg/.png only.');
          } else {
            /// call form - 
            // assign menucat & lang
            //      console.log(" call me ");
            openCreateProductForm(image);
            //$('#dlgDropToCreateProduct').dialog('open');
          }
        });
   //   });




      $('.newbox').droppable({
        accept: '.item, .fromProduct',
        onDragEnter: function (e, source) {
          $(source).addClass('tree-node-append');
          $(this).find('p').addClass('green-box');
        },
        onDragLeave: function (e, source) {
          $(this).find('p').removeClass('green-box');
        },
        onDrop: function (e, source) {
          $(this).find('p').removeClass('green-box');

          productId = $(source).attr("id");
          partno = $(source).attr("partno");
          boxno = $(this).attr("id");

          // ajax call to add to to box
          // do ajax
          fd.append('product_id', productId);
          fd.append('target_boxno', boxno);
          fd.append('lang', getSessionLang());
          fd.append('menucat', getSessionMenucat());
          fd.append('webmenu', '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');
          fd.append('partno', partno);
          $.ajax({
            url: addToBox,
            enctype: 'multipart/form-data',
            type: 'post',
            data: fd,
            async: true,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
              // console.log("DONE " + response);
              if (response.result) {
                reloadBoxes(); // function to reload #boxes
                reloadBoxesGrid();
              } else {
                console.log(" Error occured. Please contact IT admin. ");
              }

            }
          });
          // END ajax
        }
      });
      // end .box droppable

      // removebox droppable

      $('.removebox').droppable({
        accept: 'tr',
        onDragEnter: function (e, source) {
          $(source).addClass('tree-node-append');
          $(this).find('p').addClass('red-box');
        },
        onDragLeave: function (e, source) {
          $(this).find('p').removeClass('red-box');
        },
        onDrop: function (e, source) {
          $(this).find('p').removeClass('red-box');
          if ($(source).find('td .content_box').length) {
            // image list mode
            var bId = $(source).find('div.content_box').attr("b_id");
            var boxno = $(source).find('div.content_box').attr("boxno");
            var productId = $(source).find('div.content_box').attr("product_id");
            var partno = $(source).find('div.content_box').attr("partno");
            var menucat = $(source).find('div.content_box').attr("menucat");
          } else {
            // grid view mode
            var aryText = [];
            $(source).find("td").each(function () {
              aryText.push($(this).text());
            });
            var bId = aryText[0];
            var boxno = aryText[1];
            var productId = aryText[2];
            var partno = aryText[3];
            var menucat = aryText[7];
          }
          // ajax call to add to to box
          // do ajax
          fd.append('id', bId);
          fd.append('product_id', productId);
          fd.append('boxno', boxno);
          fd.append('partno', partno);
          fd.append('menucat', menucat);
          fd.append('webmenu', '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');
          fd.append('lang', getSessionLang());
          $.ajax({
            url: removeFromBoxUrl,
            enctype: 'multipart/form-data',
            type: 'post',
            data: fd,
            async: true,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
              reloadBoxes(); // function to reload #boxes
              reloadBoxesGrid();
            }
          });
          // END ajax
        }
      });
      // END removeox droppable
      setSession('viewproducts','box');
      switchProductListView('grid');
      switchBoxView('box');

      $('#listProducts').datagrid({
        url: productListUrl,
        multiSort: true,
        pageSize: 25,
        pageList: [25,50],
        pagination:true,
        rownumbers:true,
        queryParams: {
          rows:getSessionRows(),
          lang: getSessionLang(),
          page: getSessionPageNo(),
          upcoming: $('#ckb_upcoming').checkbox('options').checked,
          new: $('#ckb_new').checkbox('options').checked,
          eol: $('#ckb_eol').checkbox('options').checked,
          iscooler: $('#ckb_iscooler').checkbox('options').checked,
        },
        columns: [[
        { field: 'keychx', checkbox: true },
          { field: 'id', title: 'ID', width: '5%', sortable: true },
          {
            field: 'partno', title: 'Productcode', width:  '15%', sortable: true,
            formatter: function (value, row, index) {
              return "<span title='" + pstatusTitle[row.pstatus] + "' style='" + pstatusStyle[row.pstatus] + "; padding:3px 5px;'>" + value +
                "</span>";
            }
          },
          { field: 'name', title: 'Name', width: '22%', sortable: false },
          {
            field: 'title', title: 'Title', width: '36%', sortable: false,
            formatter: function (value, row, index) {
              return "<span title='" + row.longdesc + "' >" + row.title +
                "</span>";
            }
          },
          {
            field: 'active', title: 'Active', width: '10%', sortable: true,
            formatter: function (value, row, index) {
              if (value == 1) {
                return '<i class="bi bi-check-circle-fill icon-green icon-fs-md"></i>';
              } else {
                return '<i class="bi bi-x-circle  icon-grey icon-fs-md"></i>';
              }
              // console.log(value, row, index);
              // if (value == 1) {
              //   return '<span class="checkmark" title="Active"><div class="checkmark_circle"></div><div class="checkmark_stem"></div><div class="checkmark_kick"></div></span> In Box';
              // } else {
              //   return "<span class='checkmark'  title='Inactive'><div class='checkmark_circle_inactive'></div><div class='checkmark_stem_inactive'></div><div class='checkmark_kick_inactive'></div></span> In Box";
              // }
            },
            
          },
          { field: 'moddate', title: 'Last Modified', width: '10%', sortable: true },
        ]],
        onClickRow: function (index, row) {
          selectedBoxItem = row;
          productcode = row.productcode;
          // show pstatus() btn
          $('#edit_ps').show();
        },
        onDblClickRow: function (rowIndex, row) {
          //  console.log(row);
          let lang = $('#main_lang').combobox('getValue');
          var url = "manproducts.php?action=view&lang=" + getSessionLang() + "&partno=" + row.partno;
          OpenInNewTab(url);
        },
        onLoadSuccess: function (data) {
          setNumberOfBoxestoolbar(data.total_boxes, data.total_products);
          $(this).datagrid('enableDnd');
        }

      });
      // intial the #boxes_grid view
      $('#boxes_grid').datagrid({
        url: boxUrl,
        multiSort: true,
        queryParams: {
          lang: getSessionLang(),
          menucat: getSessionMenucat(),
          listtable: '<?php echo $_smarty_tpl->tpl_vars['listtable']->value;?>
', 
          webmenu: '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
',
        },
        columns: [[
          { field: 'bId', title: 'B ID', width: 40, sortable: true },
          { field: 'boxno', title: 'B_No', width: 45, sortable: true },
          { field: 'product_id', title: 'P_ID', width: 45, sortable: true },
          { field: 'partno', title: 'Productcode', width: 120, sortable: true,
            formatter: function (value, row, index) {
              return "<span title='" + pstatusTitle[row.pstatus] + "' style='" + pstatusStyle[row.pstatus] + "; padding:3px 5px;'>" + row.text +
                "</span>";
            }
          },
          { field: 'title', title: 'Title', width: 280, sortable: true,
            formatter: function (value, row, index) {
              return "<span title='" + row.longdesc + "' >" + row.title +
                "</span>";
            }
          },
          { field: 'box_seqno', title: 'Box Seqno', width: 50, sortable: true },
          { field: 'seqno', title: 'Seqno', width: 50, sortable: true },
          { field: 'menucat', title: 'menucat', width: 50, sortable: true, hidden: true },
          { field: 'status', title: 'Status', width: 100, sortable: true,
            formatter: function (value, row, index) {
              if (value == 1) {
                return '<i class="bi bi-check-circle-fill icon-green icon-fs-md"></i> In Box';
              } else {
                return '<i class="bi bi-x-circle  icon-grey icon-fs-md"></i>';
              }
              // console.log(value, row, index);
              // if (value == 1) {
              //   return '<span class="checkmark" title="Active"><div class="checkmark_circle"></div><div class="checkmark_stem"></div><div class="checkmark_kick"></div></span> In Box';
              // } else {
              //   return "<span class='checkmark'  title='Inactive'><div class='checkmark_circle_inactive'></div><div class='checkmark_stem_inactive'></div><div class='checkmark_kick_inactive'></div></span> In Box";
              // }
            },
          }
        ]],
        onClickRow: function (index, row) {
          selectedBoxItem = row;
          productcode = row.productcode;
          // show pstatus() btn
          $('#edit_ps').show();
        },
        onDblClickRow: function (rowIndex, row) {
          //  console.log(row);
          let lang = $('#main_lang').combobox('getValue');
          var url = "manproducts.php?action=view&lang=" + lang + "&partno=" + row.partno;
          OpenInNewTab(url);
        },
        onLoadSuccess: function (data) {
          setNumberOfBoxestoolbar(data.total_boxes, data.total_products);
          $(this).datagrid('enableDnd');
        }

      });
      // END the #boxes_grid view
      // intial the #boxes
      $('#boxes').datalist({
        url: boxUrl,
        queryParams: {
          lang: getSessionLang(),
          menucat: getSessionMenucat(),
          listtable: '<?php echo $_smarty_tpl->tpl_vars['listtable']->value;?>
', webmenu: '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
',
        },
        checkbox: false,
        lines: true,
        toolbar: '#boxes_toolbar',
        sort: {
          sortName: 'seqno',
          sortOrder: 'asc'
        },
        onClickRow: function (index, row) {
          selectedBoxItem = row;
          productcode = row.productcode;
          // show pstatus() btn
          $('#edit_ps').show();
        },
        onDblClickRow: function (rowIndex, row) {
          //  console.log(row);
          //let lang = $('#main_lang').combobox('getValue');
          var url = "manproducts.php?action=view&lang=" +  getSessionLang() + "&partno=" + row.partno;
          OpenInNewTab(url);
        },
        groupField: 'boxno',
        groupFormatter: function (value, row) {
            var box_seqno = (row[0]['box_seqno']) ? 'Box Seqno : ' + row[0]['box_seqno'] +" | ": '  ';
          var box_name = (row[0]['box_name']) ? ' | Box name : ' + row[0]['box_name'] : '  ';
          return box_seqno+"Box Number : " + value + box_name;
          // return "Box Number : " + value + box_name +
          //   '<a href="#" class="easyui-linkbutton" id="edit_product_ps" style="margin-right:5px;float:right;" onclick="pstatus()">Edit Product</a>  <a href="javascript:void(0)" style="margin-right:5px;float:right;" class="easyui-linkbutton box_group"  menucat="' + row[0]['menucat'] + '" bId="' + row[0]['bId'] + '" boxno="' + row[0]['boxno'] + '" iconCls="icon-pencil" plain="true" onclick="editBox(' +
          //   value + ')">Edit Box</a>';
        },
        textFormatter: function (value, row, index) {
          let imgdir = "/docs/products/" + row.partno + "/Web_Library/Gallery/";
          //  console.log(index);
          var content = "<div class='content_box' boxno='" + row.boxno + "' b_id='" + row.bId +
            "' product_id='" + row.product_id + "' partno='" + row.partno + "' menucat='" + row.menucat + "'>";
          content += "<div class='box_content_img'><img class='list_img product_id' width='150px' src='" + imgdir + row.docname + "'>";
          if (row.status == 1) {
            content += '<i class="bi bi-check-circle-fill icon-green icon-fs-md"></i> In Box';
          } else {
            content += '<i class="bi bi-x-circle  icon-grey icon-fs-md"></i>';
          }
          // if (row.status == 1) {
          //   content += "<span class='checkmark' title='Active'><div class='checkmark_circle'></div><div class='checkmark_stem'></div><div class='checkmark_kick'></div></span>";
          // } else {
          //   content += "<span class='checkmark'  title='Inactive'><div class='checkmark_circle_inactive'></div><div class='checkmark_stem_inactive'></div><div class='checkmark_kick_inactive'></div></span>";
          // }
          content += "</div>";
          content += "<div class='box_content_left'><p><b>Product Code : </b><span title='" + pstatusTitle[row.pstatus] + "' style='" + pstatusStyle[row.pstatus] + "; padding:3px 5px;'>" + row.text +
            "</span><br><b>Name : </b>" + row.name + "<br><b>Title : </b>" + row.title + "<br><b>Seqno : </b>" + row.seqno + "</p></div>";
          content += "<div class='box_content_right'><p><b>Long Description : </b><br>" + row.longdesc +
            "</p></div>";

          content += "</div>";
          return content;
        },
        onLoadSuccess: function (data) {
          setNumberOfBoxestoolbar(data.total_boxes, data.total_products);
          // set title
          // enable droppable boxno
          $('.datagrid-cell').droppable({
            proxy: 'clone',
            proxy: function (source) {
              console.log("proxy");
              var p = $('<div style="border:10px solid #ccc;width:80px"></div>');
              p.html($(source).html()).appendTo('body');
              return p;
            },
            onDragEnter: function (e, source) {
              console.log("datagrid-cell onDragEnter ");
              //      console.log(this);
              console.log(source);

              $(source).addClass('tree-node-append');
              $(this).addClass('green-box');
            },
            onDragLeave: function (e, source) {
              console.log("datagrid-cell onDragLeave ");
              $(this).removeClass('green-box');
            },
            onDrop: function (e, source) {
              $(this).removeClass('green-box');
              var targetBoxno = $(this).find('div.content_box').attr("boxno");
              // check class to determine the action to be taken.
              if ($(source).hasClass("fromProduct")) { // source from product list at the left
                // do ajax
                var boxno = $(this).find('div.content_box').attr("boxno");
                var productId = $(source).attr("id");
                var partno = $(source).attr("partno");
                fd.append('partno', partno);
                fd.append('product_id', productId);
                fd.append('target_boxno', targetBoxno);
                fd.append('lang', getSessionLang());
                fd.append('menucat', getSessionMenucat());
                fd.append('webmenu', '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');

                $.ajax({
                  url: addToBox,
                  enctype: 'multipart/form-data',
                  type: 'post',
                  data: fd,
                  async: true,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function (response) {
                    // $('#boxes').datalist("reload");
                    if (response.result) {
                      reloadBoxes(); // function to reload #boxes
                      reloadBoxesGrid();
                    } else {
                      console.log(" Error occured. Please contact IT admin. ");
                    }
                  }
                });
                // end ajax -- success $
              } else { // source from boxes
                // check whether same boxno
                var thisContentbox = $(this).find('div.content_box');
                var targetProductId = thisContentbox.attr("product_id");
                var targetPartno = thisContentbox.attr("partno");

                var sourceContentbox = $(source).find('div.content_box');
                var sourceBoxno = sourceContentbox.attr("boxno");
                var sourceProductId = sourceContentbox.attr("product_id");
                var sourcePartno = sourceContentbox.attr("partno");
                var sourceBid = sourceContentbox.attr("b_id");
                var menucat = $(source).find('div.content_box').attr("menucat");

                // check seq

                // ajax updateSeqFromBoxUrl
                var updateSeq = new FormData();
                updateSeq.append('source_partno', sourcePartno);
                updateSeq.append('source_product_id', sourceProductId);
                updateSeq.append('source_boxno', sourceBoxno);
                updateSeq.append('target_product_id', targetProductId);
                updateSeq.append('target_boxno', targetBoxno);
                updateSeq.append('target_partno', targetPartno);
                updateSeq.append('menucat', menucat);
                updateSeq.append('webmenu', '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');
                updateSeq.append('lang', getSessionLang());
                $.ajax({
                  url: updateSeqFromBoxUrl,
                  enctype: 'multipart/form-data',
                  type: 'post',
                  data: updateSeq,
                  async: true,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function (response) {
                    reloadBoxes(); // function to reload #boxes
                    reloadBoxesGrid();
                  }
                });

              }

            }
          }); // END enable droppable boxno

          // boxes group drag & drop
          $('.datagrid-group').draggable({
            revert: true,
            proxy: 'clone',
            onStartDrag: function () {
              console.log(" boxes group onStartDrag ");
              $(this).draggable('options').cursor = 'not-allowed';
              $(this).draggable('proxy').css('z-index', 99);
              $(this).draggable('proxy').css('background-color', 'black');
              $(this).addClass("boxesGroup");
            },
            onStopDrag: function () {
              $(this).draggable('options').cursor = 'auto';
              $(this).removeClass("boxesGroup");
            }
          });
          $('.datagrid-group').droppable({
            proxy: 'clone',
            accept: '.datagrid-group',
            proxy: function (source) {
              console.log("proxy");
              var p = $('<div style="border:10px solid #ccc;width:80px"></div>');
              p.html($(source).html()).appendTo('body');
              return p;
            },
            onDragEnter: function (e, source) {
              console.log("datagrid-group onDragEnter ");
              $(source).draggable('options').cursor = 'auto';
              $(this).addClass('group-box');
            },
            onDragLeave: function (e, source) {
              console.log("datagrid-group onDragLeave ");
              $(this).removeClass('group-box');
            },
            onDrop: function (e, source) {
              console.log(e);
              console.log(source);
              $(this).removeClass('group-box');
              // ajax
              var thisContentbox = $(this).find('a.box_group');
              var targetBoxno = thisContentbox.attr("boxno");

              var sourceContentbox = $(source).find('a.box_group');
              var sourceBoxno = sourceContentbox.attr("boxno");
              var menucat = sourceContentbox.attr("menucat");
              console.log(source);
              var updateSeq = new FormData();
              updateSeq.append('source_boxno', sourceBoxno);
              updateSeq.append('target_boxno', targetBoxno);
              updateSeq.append('menucat', menucat);
              updateSeq.append('webmenu', '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');
              console.log(" updateBoxSeqUrl ");
              $.ajax({
                url: updateBoxSeqUrl,
                enctype: 'multipart/form-data',
                type: 'post',
                data: updateSeq,
                async: true,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {

                  reloadBoxes(); // function to reload #boxes
                  reloadBoxesGrid();
                }
              });
            }
          });
          // add drag to box item

          $('.datalist .datagrid-row').draggable({
            revert: true,
            proxy: 'clone',
            onStartDrag: function () {
              console.log(" datalist onStartDrag ");
              $(this).draggable('options').cursor = 'not-allowed';
              $(this).draggable('proxy').css('z-index', 99);
              $(this).draggable('proxy').css('background-color', 'black');
              $(this).addClass("fromBox");
            },
            onStopDrag: function () {
              $(this).draggable('options').cursor = 'auto';
              console.log(" datalist onStopDrag ");
              $(this).removeClass("fromBox");
            }
          });
          // end add drag to box item
        }
      });

      $('input#search_partno').keyup(function () {
        getListProduct();
      });

      $('#productmenu').datagrid({
        title: 'New 2022 Product Menu',
        width: 230,
        height: 100,
        //    toolbar: '#productmenutoolbar',
        showHeader: false,
        singleSelect: true,
        pagination: false,
        pageSize: 20,
        pageList: [20, 30, 40],
        view: cardview_productmenu,
        // url:'mannavmenu.php?action=showproductmenu&tablename=2022_prodlist',
        columns: [[
          { field: 'y', title: 'YEAR', width: 150, sortable: true },
          { field: 'group_cat', title: 'Group Category', width: 150, sortable: true },
          { field: 'category', title: 'Category', width: 180, sortable: true },
          { field: 'subcat', title: 'Sub Category', width: 180, sortable: true },
        ]],
      });




    }); // end document ready

    var cardview_productmenu = $.extend({}, $.fn.datagrid.defaults.view, {
      renderRow: function (target, fields, frozen, rowIndex, rowData) {
        var cc = [];
        if (!frozen && rowData.id) {
          cc.push('<div style="float:left;margin-left:2px;width:250px;">');
          for (var i = 0; i < fields.length; i++) {
            if (i == 0) {
              cc.push('<span class="c-label"><b> ' + rowData[fields[i]] + ':</b></span><br>');
            } else {
              var copts = $(target).datagrid('getColumnOption', fields[i]);
              cc.push(rowData[fields[i]]);
              if (fields.length != i + 1) {
                cc.push('/');
              }
            }
          }
          cc.push('</div>');
        }
        return cc.join('');
      }
    });

    function dropNewProductImage(image) {
      var formImage = new FormData();
      formImage.append('new_product_image', image[0]);
      // call dialog

    }
    function gotoEditProduct(p) {
      
      var url = "manproducts.php?action=view&lang="+getSessionLang()+"&partno=" + p;
      OpenInNewTab(url);
    }

    function OpenInNewTab(url) {
      var win = window.open(url, '_blank');
      win.focus();
    }

    function reloadBoxes() {
      $('#boxes').datalist({
        url: boxUrl,
        queryParams: {
          lang: getSessionLang(),
          menucat: getSessionMenucat(),
          listtable: '<?php echo $_smarty_tpl->tpl_vars['listtable']->value;?>
', webmenu: '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
',

        }
      });
    }
    function reloadBoxesGrid() {
      $('#boxes_grid').datagrid({
        url: boxUrl,
        queryParams: {
          lang: getSessionLang(),
          menucat: getSessionMenucat(),
          listtable: '<?php echo $_smarty_tpl->tpl_vars['listtable']->value;?>
', webmenu: '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
',

        }
      });
    }

    function reloadListProduct(){
      $('#listProducts').datagrid({
        url: productListUrl,
        queryParams: {
          rows:getSessionRows(),
          lang: getSessionLang(),
          page: getSessionPageNo(),
          partno: $('#search_partno').val(),
          upcoming: $('#ckb_upcoming').checkbox('options').checked,
          new: $('#ckb_new').checkbox('options').checked,
          eol: $('#ckb_eol').checkbox('options').checked,
          iscooler: $('#ckb_iscooler').checkbox('options').checked,
        }
      });
    }

    function exportBatchProduct(){
      var selectedrows = $("#listProducts").datagrid("getSelections");

        if (selectedrows.length == 0) {
          alert("Please Select a product to Export");
         // switchProductListView('grid');
        } else {
          inProgress();
          var selectedPartnos = '';
        var pldg = $('#listProducts');
        $.map(pldg.datagrid('getChecked'), function (row) {
          if (selectedPartnos) {
            selectedPartnos = selectedPartnos.concat(",", row.partno);
          } else {
            selectedPartnos = row.partno;
          }
        });

        if (selectedPartnos){
          fd = new FormData();
          fd.append('partnos', selectedPartnos);
          fd.append('batch', true);
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
              if (resp){
                endProgress("Success","Exported to akasa2206 web!","");
              } else {
                endProgress("Failed","Failed to exporte to akasa2206 web!","error");
              }
            }
          });
        }
        }
    }

    function getListProduct(menucat = "") {
      // ajax call to get list
      //console.log(" get list product : " + productWithImgUrl);
      mlang = getSessionLang();
      searchProduct.append('partno', $('#search_partno').val());
      searchProduct.append('rows', getSessionRows());
      searchProduct.append('lang', mlang);
      searchProduct.append('menucat', getSessionMenucat());
      searchProduct.append('listtable', '<?php echo $_smarty_tpl->tpl_vars['listtable']->value;?>
');
      searchProduct.append('page', getSessionPageNo());
      searchProduct.append('upcoming', $('#ckb_upcoming').checkbox('options').checked);
      searchProduct.append('new', $('#ckb_new').checkbox('options').checked);
      searchProduct.append('eol', $('#ckb_eol').checkbox('options').checked);
      searchProduct.append('iscooler', $('#ckb_iscooler').checkbox('options').checked);

      $.ajax({
        url: productWithImgUrl,
        enctype: 'multipart/form-data',
        type: 'post',
        data: searchProduct,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
          // clear ul
          $('ul#imgListProducts').empty()
          // handle response
          response.forEach(function (resp) {
            var tpl = tplProductItemList;
            //let imgdir = "";
            let imgdir = "/docs/products/" + resp.partno + "/Web_Library/Gallery/";
            // if (resp.dir){
            //   imgdir = resp.dir;
            // } else {
            //   if (resp.itype =="gallery"){
            //     imgdir = "/docs/products/" + resp.partno + "/Web_Library/Gallery/";
            //   } else {
            //     imgdir = "/docs/products/" + resp.partno + "/Web_Library/Features/";
            //   } 
            // }
            let docname = resp.partno + "_g00.jpg";
            tpl = tpl.replace(/PID/g, resp.product_id)
            tpl = tpl.replace(/DIR/g, imgdir)
            tpl = tpl.replace(/DOCNAME/g, docname)
            tpl = tpl.replace(/PSTYLE/g, ' style="' + pstatusStyle[resp.pstatus] + '; padding:3px 5px;" ')
            tpl = tpl.replace(/LINKPARTNO/g, "'" + resp.partno + "'")
            tpl = tpl.replace(/PARTNOID/g, resp.partno)
            tpl = tpl.replace(/PARTNO/g, '<span title="' + pstatusTitle[resp.pstatus] + '">' + resp.partno +
              '</span>')
            $("#imgListProducts").append(tpl);

          });
          $('.products .item').draggable({
            revert: true,
            proxy: 'clone',
            onClickRow: function (index, row) {
              selectedBoxItem = row;
              console.log(" click this products ");
              // show pstatus() btn
              $('#edit_product_ps').show();
            },
            onStartDrag: function () {
              console.log("item onStartDrag ");
              $(this).draggable('options').cursor = 'not-allowed';
              $(this).draggable('proxy').css('z-index', 99);
              $(this).addClass("fromProduct");
            },
            onStopDrag: function () {
              console.log("item onStopDrag ");
              $(this).draggable('options').cursor = 'auto';
              $(this).removeClass("fromProduct");
            }
          });
          //     $(".boxes").datagrid("reload");
          // $("ul.products").append(response)
          //  findPstatusTooltip();
        }
      });
      // end Ajax call to get list
    }

    function resetInput() {
      $('#search_partno').val("");
      getListProduct();
    }

    function CancelEditForm() {
      $('#dlgEditBox').dialog('close');
    }

    function editBox(objBox) {
      fd.append('boxno', objBox.boxno);
      fd.append('bId', objBox.bId);
      fd.append('lang', getSessionLang());
      fd.append('menucat', getSessionMenucat());
      fd.append('webmenu', '<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');

      $.ajax({
        url: getBoxUrl,
        enctype: 'multipart/form-data',
        type: 'post',
        data: fd,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
          // assign value
          console.log(resp);
          console.log(resp.data);
          if (resp.result) {
            $('#frmEditBox_box_name').textbox({
              width: 450,
              label: 'Box Name :',
              labelWidth: '140px',
              value: resp.data.box_name
            });
            $('#frmEditBox_id').textbox({
              width: 450,
              label: 'Box ID :',
              labelWidth: '140px',
              disabled: true,
              value: resp.data.id
            });
            $('#frmEditBox_boxno').textbox({
              width: 450,
              label: 'Box No :',
              labelWidth: '140px',
              disabled: true,
              value: resp.data.boxno
            });
            $('#frmEditBox_seqno').textbox({
              width: 450,
              label: 'Box Seqno :',
              labelWidth: '140px',
              value: resp.data.box_seqno
            });
            $('#frmEditBox_menucat').textbox({
              hidden: true,
              value: resp.data.menucat
            });

            $('#frmEditBox_status').combobox({
              width: 450,
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
            });
            $('#frmEditBox_status').combobox('setValue', resp.data.status);
            $('#dlgEditBox').dialog('open');
          } else {
            alert(" Error ocurred.");
          }
        }
      });

    }
    function openCreateProductForm(image) {
      let lang = getSessionLang();
      let menucat = getSessionMenucat();
      $('#frmDropToCreateProduct').find("#lang").val(lang);
      $('#frmDropToCreateProduct').find("#menucat").val(menucat);
      if (image) {
        $(".frmDropToCreateProduct_file_p").show();
        $("#frmDropToCreateProduct_file").prop("files", image);
      } else {
        $(".frmDropToCreateProduct_file_p").hide();
      }

      $('#frmDropToCreateProduct_partno').textbox({
        width: 450,
        label: 'Part No *:',
        labelWidth: '140px',
      });
      $('#frmDropToCreateProduct_title').textbox({
        width: 450,
        label: 'Tiitle :',
        labelWidth: '140px',
      });
      $('#frmDropToCreateProduct_name').textbox({
        width: 450,
        label: 'Name :',
        labelWidth: '140px',
      });
      $('#frmDropToCreateProduct_long_desc').summernote({
        tabsize: 2,
        width: 750,
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
      $('#dlgDropToCreateProduct').dialog('open');
    }

    function SubmitEditForm() {
      // do ajax call

      fdEditBox.append('box_name', $('#frmEditBox_box_name').textbox('getValue'));
      fdEditBox.append('id', $('#frmEditBox_id').textbox('getValue'));
      fdEditBox.append('boxno', $('#frmEditBox_boxno').textbox('getValue'));
      fdEditBox.append('status', $('#frmEditBox_status').textbox('getValue'));
      fdEditBox.append('box_seqno', $('#frmEditBox_seqno').textbox('getValue'));
      fdEditBox.append('menucat', $('#frmEditBox_seqno').textbox('getValue'));
      fdEditBox.append('lang', getSessionLang());
      console.log(fdEditBox);
      $.ajax({
        url: updateBoxUrl,
        enctype: 'multipart/form-data',
        type: 'post',
        data: fdEditBox,
        async: true,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (resp) {
          console.log(resp);
          if (resp.result) {
            reloadBoxes(); // function to reload #boxes
            reloadBoxesGrid();
            $('#dlgEditBox').dialog('close');
          }
        }
      });
    }
    function CancelDropToCreateProductForm() {
      $('#dlgDropToCreateProduct').dialog('close');
    }
    function SubmitDropToCreateProductForm() {
      // check file and partno
      if ($('#frmDropToCreateProduct_partno').textbox('getValue') == "") {
        alert("Please provide partno.");
      }
      /*  if ($('#frmDropToCreateProduct_file').val() == "") {
          alert("Please select an image file" + $('#frmDropToCreateProduct_file').val());
        }
  */

      $('#frmDropToCreateProduct').form('submit', {
        url: dropImageCreateProductUrl,
        success: function (data) {
          $('#frmDropToCreateProduct').form('submit', {
            url: uploadImgUrl,
            success: function (data) {
              $('#dlgDropToCreateProduct').dialog('close');
              reloadBoxes(); // function to reload #boxes
              reloadBoxesGrid();
              getListProduct();
            }
          });
        }
      });

    }
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
>
    // form data
    setSession('webmenu','<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');
    var fd = new FormData();
    var searchProduct = new FormData();
    var fdEditBox = new FormData();
    let fdDropNewImg = new FormData();
    // API URL for AJAX call
    var boxUrl = "manproducts.php?action=listbox";
    // var productWithImgUrl = 'manproducts_jm.php?action=list_product_with_image';
    var productWithImgUrl = backendApi + "/product/images_list";
    var productListUrl = backendApi + "/product_list";
    //var addToBox = 'manproducts.php?action=add_product_to_box';
    var addToBox = backendApi + "/boxes/product/add";
    //var removeFromBoxUrl = "manproducts.php?action=remove_product_from_box";
    var removeFromBoxUrl = backendApi + "/boxes/product/remove";
    //var getBoxUrl = "manproducts.php?action=getbox";
    var getBoxUrl = backendApi + "/boxes/data/get";
    //var updateBoxUrl = "manproducts.php?action=update_box";
    var updateBoxUrl = backendApi + "/boxes/data/update";
    var updateSeqFromBoxUrl = 'manproducts.php?action=change_seqno_from_box';
    var updateBoxSeqUrl = 'manproducts.php?action=change_box_seqno';
    //var updateStatusInBoxUrl = "manproducts.php?action=change_status_in_box";
    var updateStatusInBoxUrl = backendApi + "/boxes/product/status/update";
    var dropImageCreateProductUrl = "manproducts.php?action=drop_image_create_product";
    var uploadImgUrl = "manimages.php?action=save";
    var exportAllLists = "exportproduct_queue.php?type=list&lang="+getSessionLang()+"&webmenu=new&menucat=all";

    // box item tpl
    var tplProductItemList =
      '<li onclick="itemSelected(LINKPARTNO)"><a href="javascript:void(0);" ondblclick="gotoEditProduct(LINKPARTNO)" class="item" id="PID" partno="PARTNOID"><img width="300px" src="DIRDOCNAME" /></a><div><p PSTYLE>PARTNO</p></div></li>';
    // select box item
    var selectedBoxItem = [];
    var productcode = '';
    // select product list item
    var plSelectedItem = [];
    var plProductcode = '';
    
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
>
    function pstatus() {
      startPstatusForm();
      if (selectedBoxItem == "") {
        alert(" Please select one of product in the product List. Thank you.");
      } else {
        // get clone frmProductStatusSelect
        console.log(selectedBoxItem);
        var elem = $("#frmProductStatusSelect").clone().attr('id', 'id' + selectedBoxItem.product_id);
        elem.find('div.product').text("Product : " + selectedBoxItem.text);
        elem.find('select').attr('name', 'new_pstatus');
        elem.find('select').val(selectedBoxItem.pstatus);
        $("#divPstatus").append(elem);
        $('#frmProductStatus_inputseqno').textbox('setValue', selectedBoxItem.seqno);
        if (selectedBoxItem.eol_comment) {
          $("#frmProductStatus_eol_comment").val(selectedBoxItem.eol_comment);
          $("#frmProductStatus_eol").show();
        }
        $("#frmProductStatus_pid").val(selectedBoxItem.product_id);
        $("#frmProductStatus_partno").val(selectedBoxItem.text);
        // add box status
        $("#frmProductStatus_boxid").val(selectedBoxItem.bId);
        $("#frmProductStatus_webmenu").val('<?php echo $_smarty_tpl->tpl_vars['webmenu']->value;?>
');
        $("#frmProductStatusSelect").hide();
        $('#dlg_pstatus').dialog('open');
      }
    }

    function openEditBox() {
      if (selectedBoxItem == "") {
        alert(" Please select one of product in the product List. Thank you.");
      } else {
        editBox(selectedBoxItem);
      }
    }

    function cancelChangeStatusForm() {
      $('#dlg_pstatus').dialog('close');
    }

    function submitChangeStatusForm() {
      // do ajax call
      /*
      $('#frmProductStatus').form('submit', {
        url: 'manakasaproduct.php?action=pstatus',
        success: function (resp) {
          if (resp) {  resetPstatusForm();  }
        }
      });
      */
      // change status
      // updateStatusInBoxUrl
      $('#frmProductStatus').form('submit', {
        url: updateStatusInBoxUrl,
        success: function (resp) {
          if (resp) {
            resetPstatusForm();
          }
        }
      });


      $('#dlg_pstatus').dialog('close');
    }

    function checkEOLStatus(selected) {
      if (selected.value == "6") {
        // show EOL comment
        $("#frmProductStatus_eol").show();

      }
    }

    function resetPstatusForm() {
      $("#frmProductStatus_eol_comment").val("");
      reloadBoxes(); // function to reload #boxes
      reloadBoxesGrid()
      $("#divPstatus").empty();
    }

    function startPstatusForm() {
      $("#frmProductStatusSelect").show();
      $("#frmProductStatus_eol").hide();
      $("#frmProductStatus_eol_comment").val("");
      $("#frmProductStatus_inputseqno").val("");

      $("#divPstatus").empty();
    }
    // end pstatus
    // function
    function showlist(menucat, title) {
      console.log(getSessionLang());
      smenucat = menucat;
      setPanelTitleWithLang(getSessionLang(), title);
      setSessionMenucat(menucat, title);
      reloadBoxes(); // function to reload #boxes
      reloadBoxesGrid();
    }
    // function in product list selected item
    function itemSelected(partno) {
      console.log(partno);
      // search product menu
      var url = "mannavmenu.php?action=showproductmenu&productcode=" + partno;
      $("#productmenu").datagrid({ url: url });
      //$("#productmenu").datagrid("reload");
      var dgPanel = $("#productmenu").datagrid('getPanel');
      dgPanel.panel('setTitle', 'Product Menu For: ' + partno);
    }
  <?php echo '</script'; ?>
>

  <!-- Begin pstatus dialog-->
  <div class="easyui-dialog" id="dlg_pstatus" data-options="resizable:true"
    style="width:500px;height:500px;padding:10px 10px" closed="true" title='Edit Product'>
    <form id="frmProductStatus" enctype="multipart/form-data" method="post">
      <input type="text" id="frmProductStatus_pid" name="id" hidden=true>
      <input type="text" id="frmProductStatus_partno" name="partno" hidden=true>
      <input type="text" id="frmProductStatus_boxid" name="boxid" hidden=true>
      <input type="text" id="frmProductStatus_webmenu" name="webmenu" hidden=true>
      <div id="divPstatus"></div>
      <div id="frmProductStatusSelect">
        <div class="product" style="text-align: right; width: 300px; height: 30px; line-height: 30px;"></div>
        <label class="textbox-label textbox-label-before" for="_easyui_textbox_input14"
          style="text-align: right; width: 180px; height: 30px; line-height: 30px;">Product Status :</label>
        <select name="pstatus" style="width: 240px; height: 40px; line-height: 30px;" onchange="checkEOLStatus(this)">
          <option value="1">Upcoming </option>
          <option value="7">Pre-Order</option>
          <option value="2">New</option>
          <option value="3">Current</option>
          <!-- <option value="4">EOL or Legacy consideration</option> -->
          <option value="5">Legacy</option>
          <option value="6">EOL</option>
          <option value="8">Hidden</option>
        </select>
      </div>


      <div id="frmProductStatus_eol" style="display:none" style="margin: 5px">
        <label class="textbox-label textbox-label-before" for="_easyui_textbox_input14"
          style="text-align: right; width: 180px; height: 40px; line-height: 30px;">EOL comment :</label>
        <input type="text" class="textbox-text" id="frmProductStatus_eol_comment" name="eol_comment"
          style="height: 40px; line-height: 28px; width:240px;">
      </div>
      <!-- <label class="textbox-label textbox-label-before"
        style="text-align: right; width: 180px; height: 30px; line-height: 30px;">Status in box :</label>
      <select id="status" name="status" style="width: 240px; height: 40px; line-height: 30px;">
        <option value="1">Active </option>
        <option value="0">inactive</option>
      </select> -->
      <div id="frmProductStatus_seqno" style="margin: 5px">
        <input id="frmProductStatus_inputseqno" class="easyui-textbox" name="seqno" style="width:240px;"
          data-options="label:'SeqNo:',labelWidth:'180px',labelAlign:'right'">
      </div>

    </form>
    <div style="text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitChangeStatusForm()"
        style="width:80px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelChangeStatusForm()"
        style="width:80px">Cancel</a>
    </div>
  </div>
  <!-- END pstatus dialog-->
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

  <!-- Begin Drop image create new product form-->
  <div class="easyui-dialog" id="dlgDropToCreateProduct" data-options="resizable:true"
    style="width:800px;height:600px;padding:10px 10px" closed="true" title="Drop Image to create new product">
    <form id="frmDropToCreateProduct" method="POST" enctype="multipart/form-data">
      <input type="text" id="id" name="id" value="-1" hidden=true>
      <input type="text" id="caption" name="caption" hidden=true>
      <input type="text" id="comment" name="comment" hidden=true>
      <input type="text" id="seqno" name="seqno" hidden=true>
      <input type="text" id="ctype" name="ctype" value="Features" hidden=true>
      <input type="text" id="menucat" name="menucat" value="" hidden=true>
      <input type="text" id="lang" name="lang" value="en" hidden=true>
      <input type="text" id="pstatus" name="pstatus" value="en" hidden=true>
      <p class="frmDropToCreateProduct_file_p"><label class="textbox-label textbox-label-before lbl_140" for="">Drop
          Image File *:</label>
        <input id="frmDropToCreateProduct_file" name="imagefile" type="file">
      </p>
      <p><input id="frmDropToCreateProduct_partno" name="partno" type="text"></p>
      <p><input id="frmDropToCreateProduct_name" name="name" type="text"></p>
      <p><input id="frmDropToCreateProduct_title" name="title" type="text"></p>
      <p><label class="textbox-label textbox-label-before lbl_140" for="">Long Desc:</label><br>
        <textarea id="frmDropToCreateProduct_long_desc" class="summernote" name="long_desc"></textarea>
      </p>
    </form>
    <div style=" text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="SubmitDropToCreateProductForm()"
        style="width:80px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="CancelDropToCreateProductForm()"
        style="width:80px">Cancel</a>
    </div>
  </div>
  <!-- End Drop image create new product form-->
</body>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
